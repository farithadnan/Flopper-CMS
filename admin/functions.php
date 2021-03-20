
<?php 

//============== DATABASE HELPER FUNCTION ==============//

// ----------------------------------------------------------//
//  Function that wil redirect user to a specified path      //
// ----------------------------------------------------------//
function redirect($location)
{
	return header("Location:" . $location);
	exit;
}

// --------------------------------------------------------------//
//  Function that wil help simplified the usage of mysqli_query  //
// --------------------------------------------------------------//
function query($query){
	global $connection;
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	return $result;
}

// ----------------------------------------------------------//
//  Function that is used to do filtration from a user input //
// ----------------------------------------------------------//
function escape($string) {

	global $connection;

	return mysqli_real_escape_string($connection, trim($string));
}

// -----------------------------------------------------------------------------------//
//  Query Checker function, this will determine wheteher the query is executed or not //
// -----------------------------------------------------------------------------------//
function confirmQuery($result) {

	global $connection;

	if (!$result) {
		die('QUERY FAILED ' . mysqli_error($connection). ' ' . mysqli_errno($connection));
	}

}

// ---------------------------------------------------------------//
//  Function that wil help fetching data using mysqli_fetch_array //
// ---------------------------------------------------------------//
function fetchRecords($result){
	return mysqli_fetch_array($result);
}

// ------------------------------------------------------------//
//  Function that wil help fetching data using mysqli_num_rows //
// ------------------------------------------------------------//
function count_records($result){
	return mysqli_num_rows($result);
}
//============ END DATABASE HELPER FUNCTION ============//






//=============== AUTHENTICATION HELPER  ===============//

// -----------------------------------------------------//
//  Function that wil check if a user logged in or not  //
// -----------------------------------------------------//
function isLoggedIn(){

	if(isset($_SESSION['user_role'])){
		return true;
	}

	return false;
}

// -----------------------------------------------------------------//
//  This function is used to check if the user role is admin or not //
// -----------------------------------------------------------------//
function is_admin(){

	global $connection;
	error_reporting(0);

	if (isLoggedIn())
	{
		$result = query("SELECT user_role FROM users WHERE user_id =".$_SESSION['user_id']." ");

		$row = fetchRecords($result);
		$user_role = $row['user_role'];

		if($user_role === 'Admin')
		{
			return True;

		} 
		else
		{
			return False;
		}
	}

	return false;
}


// ------------------------------------------------------------------------//
//  Function that wil check if a user logged in and redirect it if its yes //
// ------------------------------------------------------------------------//
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
	if (isLoggedIn()){

		redirect($redirectLocation);
	}
}

// -------------------------------------//
//  Function for executing login query  //
// -------- ----------------------------//
function login_user($username, $password){

	global $connection; 

	$username = escape($username);
	$password =escape($password);
	$select_user_query = query("SELECT * FROM users WHERE username = '{$username}'");

	//fetch assoc; associative array array with define name, and assined value to this name
	//fetch array: numeric array without defined name only define my number like 0,1,2 to store an assign value
	while ($row = mysqli_fetch_array($select_user_query)) 
	{
		$db_user_id = $row['user_id'];
		$db_username = $row['username'];
		$db_user_password = $row['user_password'];
		$db_user_firstname = $row['user_firstname'];
		$db_user_lastname = $row['user_lastname'];
		$db_user_role = $row['user_role'];


		if(password_verify($password, $db_user_password))
		{
			$_SESSION['user_id'] = $db_user_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['firstname'] = $db_user_firstname;
			$_SESSION['lastname'] = $db_user_lastname;
			$_SESSION['user_role'] = $db_user_role;

			redirect("/project/cms/admin/index");

		} else {
			return false;
		}
	}
	return true;
}


//============= END AUTHENTICATION HELPER  =============//






//==================  GENERAL HELPER  ==================//

// ----------------------------------------------------------//
//  Function that wil return current user that logged in     //
// ----------------------------------------------------------//
function currentUser()
{
	return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

// ---------------------------------------------------------------//
//  Function that wil return current user role that logged in     //
// ---------------------------------------------------------------//
function currentRole()
{
	return isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
}

// ------------------------------------------------//
//  Function that wil return the current user id   //
// ------------------------------------------------//
function loggedInUserId(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
        $user = fetchRecords($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;

}

// -----------------------------------//
//  Function that wil check a method  //
// -----------------------------------//
function ifItIsMethod($method=null){
	if($_SERVER['REQUEST_METHOD'] == strtoupper($method))
	{
		return true;
	}

	return false;
}


// -------------------------------------------------------------------------------------//
//  Function for displaying the current number of user that currently using this system //
// -------------------------------------------------------------------------------------//
function users_online(){

	if(isset($_GET['onlineusers']))
	{

		global $connection;

		if(!$connection)
		{
			session_start();

			include("../includes/db.php");

			$session = session_id();
		    $time = time();
		    $time_out_in_second = 5;
		    $time_out = $time - $time_out_in_second;

		    $send_query = query("SELECT * FROM user_online WHERE session = '$session'");
		    $count = mysqli_num_rows($send_query);

			    if($count == NULL)
			    {
			        query("INSERT INTO user_online(session, time_log) VALUES('$session','$time')");
			    }
			    else 
			  	{
			        query("UPDATE user_online SET time_log = '$time' WHERE session = '$session' ");
			    }

		    $user_online_query = query("SELECT * FROM user_online WHERE time_log > '$time_out'");
		    echo $count_user = mysqli_num_rows($user_online_query);	

			}

	} //get request isset
}
users_online();

// ------------------------------------//
//  Function for single delete option  //
// -------- ---------------------------//
function delete_option($id, $table, $column, $page)
{
	global $connection;

    if(isLoggedIn())
    {
        $the_id =  escape($id);
        $deleteQuery = query("DELETE FROM $table WHERE $column = {$the_id} ");
        redirect("$page");       
    }
}

//================  END GENERAL HELPER  ================//






//============== REGISTRATION RELATED HELPER  ==============//

// -------------------------------------------------------------------------------------------------------------//
//  Function that is used to check whether the username that user inputted already existed in the system or not //
// -------------------------------------------------------------------------------------------------------------//
function username_exists($username)
{
	global $connection;

	$result = QUERY("SELECT username FROM users WHERE username = '$username'");

	if(mysqli_num_rows($result) > 0)
	{
		return true;
	} else {
		return false;
	}
}

// ------------------------------------------------------------------------------------------//
//  Function that is used to check whether the email is already existed or not in the system //
// ------------------------------------------------------------------------------------------//
function email_exists($email)
{
	global $connection;

	$result = query("SELECT user_email FROM users WHERE user_email = '$email'");
	if(mysqli_num_rows($result) > 0)
	{
		return true;
	} else {
		return false;
	}
}


// -------------------------------------------------//
//  Function for executing user registration query  //
// -------------------------------------------------//

function register_user($username, $email, $password)
{
	global $connection;
     
    $username = escape($username );
    $email    = escape($email);
    $password = escape($password);
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', 'Subscriber')";
    $register_user_query = query($query);

    confirmQuery($register_user_query);
}


//============ END REGISTRATION RELATED HELPER  ============//





//================= USER DASHBOARD HELPER  ================//

function get_all_user_posts() {
	return query("SELECT * FROM posts WHERE user_id=". loggedInUserId() ."");
}

function get_all_post_user_comments() {
	return $result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id
	WHERE user_id =". loggedInUserId() ."");
}

function get_all_post_user_categories() {
		return query("SELECT * FROM categories WHERE user_id=". loggedInUserId() ."");
}

function get_all_user_published_posts() {
    return $result = query("SELECT * FROM posts WHERE user_id=". loggedInUserId() ." AND post_status = 'Published'");
}
function get_all_user_draft_posts() {
    return $result = query("SELECT * FROM posts WHERE user_id=". loggedInUserId() ." AND post_status = 'Draft'");
}
function get_all_user_approved_posts_comments() {
	return $result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id
	WHERE user_id =". loggedInUserId() ." AND comment_status='Approved'");
}
function get_all_user_unapproved_posts_comments() {
	return $result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id
	WHERE user_id =". loggedInUserId() ." AND comment_status='Unapproved'");
}
//=============== END USER DASHBOARD HELPER  ==============//





//=============== ADMIN DASHBOARD HELPER  ==============//

// ----------------------------------------------------//
//  Displaying count for card-count in index.php admin //
// ----------------------------------------------------//
function recordCount($table) {

	global $connection;

	 $select_all = query("SELECT * FROM " . $table);
     $result = mysqli_num_rows($select_all);
     confirmQuery($result);
     return $result;
}

// ---------------------------------------------------------------------------//
//  Function for checking post status, comment status in index.php admin page //
// ---------------------------------------------------------------------------//
function checkStatus($table, $column, $status) {

	global $connection;

    $result = query("SELECT * FROM $table WHERE $column = '$status'");
    return mysqli_num_rows($result);
}

// ------------------------------------------------------//
//  Function for checking user role index.php admin page //
// ----------------------------------------------------- //
function checkUserRole($table, $column, $role) {

	global $connection;

	$result = query("SELECT * FROM $table WHERE $column = '$role' ");
    return mysqli_num_rows($result);
}


//============== END ADMIN DASHBOARD HELPER ============//






//================ POST RELATED HELPER  ================//

// -------------------------------------------------------------------//
//  Function that wil check if a user like that specific post or not  //
// -------------------------------------------------------------------//
function userLikedThisPost($post_id){
    $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
    return mysqli_num_rows($result) >= 1 ? true : false;
}

// -------------------------------------------------------------------//
//  Function that wil check if a user like that specific post or not  //
// -------------------------------------------------------------------//
function getPostLikes($post_id){

    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    echo mysqli_num_rows($result);
}


// ------------------------------------------------------------//
//  Function that wil filter post id then return the post user //
// ------------------------------------------------------------//
function filterEditPost($the_post_id)
{
	global $connection;

	$select_author = query("SELECT * FROM posts WHERE post_id = {$the_post_id}");
	$row = mysqli_fetch_assoc($select_author);
	$post_author_filter = $row['post_user'];

	return $post_author_filter;

}
// --------------------------------------------------------------------------------------------//
//  Function that wil post default picture if the post doesnt have any image assigned to it    //
// -------------------------------------------------------------------------------------------//
function imagePlaceholder($image=''){
	if(!$image){
		return 'no-image.jpg';
	}else{
		return $image;
	}
}

// -------------------------------------//
//  Function for bulking option in post //
// -------- ----------------------------//
function bulking_option_post($checBoxArray, $bulk_choices){

	global $connection;

    foreach ($checBoxArray as $postValueId) {
        $bulk_options = escape($bulk_choices);

        switch ($bulk_options) {

            case 'Published':
                $update_to_published_status = query("UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ");
                break;

            case 'Draft':
                $update_to_draft_status = query("UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ");
                break;

            case 'delete':
                $update_to_delete_status = query("DELETE FROM posts WHERE post_id = {$postValueId} ");
                break;  

            case 'clone':
                $select_post_query = query("SELECT * FROM posts WHERE post_id = {$postValueId} ");

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_user = escape($row['post_user']);
                    $post_title = escape($row['post_title']);
                    $post_category_id = escape($row['post_category_id']);
                    $post_status = escape($row['post_status']);
                    $post_image = $row['post_image'];
                    $post_tag = escape($row['post_tag']);
                    $post_date = escape($row['post_date']);
                    $post_content = escape($row['post_content']);
                }

                $copy_query = query("INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tag,  post_status) VALUES({$post_category_id},'$post_title','$post_user', now(),'{$post_image}','{$post_content}','{$post_tag}','{$post_status}')");
                break;  


            case 'reset':
                $reset_views_count = query("UPDATE posts SET post_view_count = 0 WHERE post_id =" . escape($postValueId) . "");
                break;                
        }
    }
}

// ----------------------------//
//  Function to view all  post //
// -------- -------------------//
function view_all_post()
{
	global $connection;
    //find all posts query

    $query = "SELECT posts.post_id, posts.user_id, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
    $query .= "posts.post_tag, posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.user_id, categories.cat_title ";
    $query .= " FROM posts";
    $query .= " LEFT JOIN categories ON posts.post_category_id = categories.cat_id";
    $select_posts = query($query);
    

  
    while ($row = mysqli_fetch_assoc($select_posts)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_view_count = $row['post_view_count'];
        $category_id = $row['cat_id'];
        $category_title = $row['cat_title'];

        if($post_user === currentUser())
        {

        echo "<tr>";
        ?>
            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $post_id ?>"></td>
        <?php
        echo "<td> $post_id </td>";
        echo "<td> $post_user </td>";
        echo "<td> $post_title </td>";
        echo "<td> {$category_title} </td>";
        echo "<td> $post_status </td>";
        echo "<td><img class='img-responsive' width='100' src='../images/$post_image' alt='images'>  </td>";
        echo "<td> $post_tag </td>";

        // This is to preview comment count for each post, by using mysqli num rows function
        $send_comment_query = query("SELECT * FROM comments WHERE comment_post_id = $post_id");
        $row = fetchRecords($send_comment_query);
        $comment_id = isset($row['comment_id']);
        $count_comments = mysqli_num_rows($send_comment_query);
                
        echo "<td> <i class='fa fa-comments'></i><a href='post_comments.php?id=$post_id'> $count_comments</a> </td>";
        echo "<td> $post_date</td>";
        echo "<td> <i class='fa fa-user'></i> <a href='#'>$post_view_count</a> </td>";

        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
        echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}' title='View Post'> <i class='fa fa-eye'></i> View</a></td>";
        echo "<td><a  class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}' title='Edit Post'><i class='fa fa-pencil'></i> Edit</a></td>";
        ?>
            <form method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

                <?php  
                echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';
                 ?>
            </form>
        <?php

        //echo "<li><a rel='$post_id' href='javascript:void(0)' class='delete_link' title='Delete Post'><i class='fa fa-trash'></i> Delete</a></li>"
        echo "</tr>";
        }
    } 	
}

// ---------------------------------------//
//  Function for reset view count in post //
// -------- ------------------------------//
function reset_option($reset)
{
	global $connection;

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'Admin')
        {
            $the_post_id =  escape($reset);
            $resetQuery = query("UPDATE posts SET post_view_count = 0 WHERE post_id =" . escape($the_post_id) . "");
            redirect("posts.php");
        }
    }
}


//============== END POST RELATED HELPER  ==============//






//============== CATEGORY RELATED HELPER  ==============//

// --------------------------------------------------------//
//  This function is used in inserting a new post Category //
// --------------------------------------------------------//
function insert_categories() {

	global $connection;

    if(isset($_POST['submit']))
    {

    $cat_title = escape($_POST['cat_title']);

	    if($cat_title =="" || empty($cat_title))
	    {
	        echo "This field should not be empty";

	    } else
	    	{
	        $stmt = mysqli_prepare($connection,"INSERT INTO categories(cat_title, user_id) VALUES(?, ?)");
	        mysqli_stmt_bind_param($stmt, 'ss', $cat_title, loggedInUserId());
	        mysqli_stmt_execute($stmt);
	        confirmQuery($stmt);

	        mysqli_stmt_close($stmt);
	    	}
	}

}


// -------------------------------------------------------------------//
//  This function is used to display all the existing post's category //
// -------------------------------------------------------------------//
function findAllCategories() {

	global $connection;


	$select_categories = query("SELECT * FROM categories WHERE user_id =".loggedInUserId().""); //select all from table categories 
	

	

	while ($row = mysqli_fetch_assoc($select_categories)) 
	{ //amek and tukarkan column kepada key, and anak2 column as value dia s
		$cat_id = escape($row['cat_id']);
		$cat_title = escape($row['cat_title']);

		echo"<tr>";
		echo " <td>{$cat_title}</td>";
	    echo "<td> <a class='btn btn-info' href='categories.php?edit={$cat_id}' title='Edit Category'><i class='fa fa-pencil'></i> Edit</a></td>";
	    ?>
	        <form method="post">
                <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">

                <?php  
                echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';
                 ?>
            </form>

        <?php
		echo "</tr>";

		// ---------------------------------------------------------------//
		//  This function is used in deleting the existing post Category //
		// --------------------------------------------------------------//
		if (isset($_POST['delete'])) {
   			delete_option($cat_id = $_POST['cat_id'], 'categories', 'cat_id', 'categories.php');
		}
	}

}


// --------------------------------------------------------------//
//  This function is used in Updating the existing post Category //
// --------------------------------------------------------------//
function editCategories() {
	global $connection;
	
    if (isset($_GET['edit'])) {
		if(isLoggedIn())
		{
	      $cat_id = escape($_GET['edit']);
          include "includes/update_categories.php";    
		}
    }

}


//============ END CATEGORY RELATED HELPER  ============//





//============== COMMENT RELATED HELPER  ===============//

// ----------------------------------------//
//  Function for bulking option in comment //
// -------- -------------------------------//
function bulking_option_comment($checBoxArray, $bulk_choices)
{
	global $connection;

    foreach ($checBoxArray as $commentValueId) {
        $bulk_options = escape($bulk_choices);

        switch ($bulk_options) {

            case 'Approved':
               $update_to_approve_status = query("UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ");
                break;

            case 'Unapproved':
                $update_to_unapprove_status = query("UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ");
                break;

            case 'Delete':
                $update_to_delete_status = query("DELETE FROM comments WHERE comment_id = {$commentValueId} ");
                break;  
        }
    }
}

// ------------------------------------//
//  Function for viewing all  comment  //
// -------- ---------------------------//
function find_all_comment()
{
	global $connection;
	$user = currentUser();

	$select_user_post = query("SELECT post_id, post_user FROM posts WHERE post_user = '{$user}'");
	while($row_post = mysqli_fetch_assoc($select_user_post))
	{
		$post_id = $row_post['post_id'];
		$post_user = $row_post['post_user'];

	    //find all comment query
	     $select_comments = query("SELECT * FROM comments WHERE comment_post_id = {$post_id} ORDER BY comment_id DESC "); //select all from table posts 

	    while ($row = mysqli_fetch_assoc($select_comments)) 
	    { //amek and tukarkan column kepada key, and anak2 column as value dia s
	        $comment_id = escape($row['comment_id']);
	        $comment_post_id = escape($row['comment_post_id']);
	        $comment_author = escape($row['comment_author']);
	        $comment_content = escape($row['comment_content']);
	        $comment_email = escape($row['comment_email']);
	        $comment_status = escape($row['comment_status']);
	        $comment_date = escape($row['comment_date']);

	        echo "<tr>";
	        ?>
	            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $comment_id ?>"></td>
	        <?php
	        echo "<td> $comment_id </td>";
	        echo "<td> $comment_author </td>";
	        echo "<td> $comment_content </td>";
	        echo "<td> $comment_email </td>";
	        echo "<td> $comment_status </td>";

	        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
	        $select_post_id_query = query("SELECT * FROM posts WHERE post_id = {$comment_post_id}");

	        while ($row = mysqli_fetch_assoc($select_post_id_query)) {
	            $post_id = escape($row['post_id']);
	            $post_title = escape($row['post_title']);

	            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
	        }

	        echo "<td> <i class='fa fa-calendar'></i> $comment_date </td>";
	        echo "<td> <a class='btn btn-success' href='comments.php?approve={$comment_id}' title='Approve Post'> <i class='fa fa-check'></i> Approve</a></td>";
	        echo "<td> <a class='btn btn-info' href='comments.php?unapprove={$comment_id}' title='Unapprove Post'><i class='fa fa-times'></i> Unapprove</a></td>";
	    ?>
	        <form method="post">
	            <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
	            <?php echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>'; ?>
	        </form>
	    <?php
	       echo "</tr>";

	        // ---------------------------------------------------------//
	        //  This function is used in deleting the existing comment  //
	        // ---------------------------------------------------------//
	        if (isset($_POST['delete'])) {
	            delete_option($comment_id = $_POST['comment_id'], 'comments', 'comment_id', 'comments.php');
	        }
	    }
    }
}

// --------------------------------------------------------------------------------//
//  This function is used in set the comment approval status the existing comment  //
// ----------------------------------------------------------------------------- --//
function comment_approval($approval, $status, $path)
{
	global $connection;

    if(isLoggedIn())
    {

            $the_comment_id =escape($approval);
            $approveQuery = query("UPDATE comments SET comment_status = '$status'  WHERE comment_id = {$the_comment_id} ");
            confirmQuery($approveQuery);
            redirect("$path");        
 
    }
}

// ---------------------------------------------//
//  Function for bulking option in post comment //
// -------- ------------------------------------//
function bulking_option_post_comment($checBoxArray, $bulk_choices)
{
    global $connection;
     
    foreach ($checBoxArray as $commentValueId) {
        $bulk_options = escape($bulk_choices);

        switch ($bulk_options) {
            case 'Approved':
               $update_to_approve_status = query("UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ");
                break;

            case 'Unapproved':
                $update_to_unapprove_status = query("UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ");
                break;

            case 'Delete':
                $update_to_delete_status = query("DELETE FROM comments WHERE comment_id = {$the_comment_id} ");
                break;  
        }
    }
}

// ------------------------------------------//
//  Function for viewing all in post comment //
// -------- ---------------------------------//
function find_all_post_comment()
{
	global $connection;
     $select_comments = query("SELECT * FROM comments WHERE comment_post_id =".escape( $_GET['id']) . "") ; 

    while ($row = mysqli_fetch_assoc($select_comments)) 
    { 
        $comment_id = escape($row['comment_id']);
        $comment_post_id = escape($row['comment_post_id']);
        $comment_author = escape($row['comment_author']);
        $comment_content = escape($row['comment_content']);
        $comment_email = escape($row['comment_email']);
        $comment_status = escape($row['comment_status']);
        $comment_date = escape($row['comment_date']);

        echo "<tr>";
        ?>
            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $comment_id ?>"></td>
        <?php
        echo "<td> $comment_id </td>";
        echo "<td> $comment_author </td>";
        echo "<td> $comment_content </td>";
        echo "<td> $comment_email </td>";
        echo "<td> $comment_status </td>";

        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
        $select_post_id_query = query("SELECT * FROM posts WHERE post_id = {$comment_post_id}");

        while ($row = mysqli_fetch_assoc($select_post_id_query)) {
            $post_id = escape($row['post_id']);
            $post_title = escape($row['post_title']);

            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }

        echo "<td> $comment_date </td>";
        echo "<td><a class='btn btn-success' href='post_comments.php?approve={$comment_id}&id=" . $_GET['id'] . "' title='Approve Post'> <i class='fa fa-check'></i> Approve</a></td>";
        echo "<td><a class='btn btn-info' href='post_comments.php?unapprove={$comment_id}&id=" . $_GET['id'] . "' title='Unapprove Post'><i class='fa fa-times'></i> Unapprove</a></td>";

        ?>
            <form method="post">
                <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                <?php echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>'; ?>
            </form>
        <?php
         echo "</tr>";

        // ---------------------------------------------------------//
        //  This function is used in deleting the existing comment  //
        // ---------------------------------------------------------//
        if (isset($_POST['delete'])) {
            delete_option($comment_id = $_POST['comment_id'], 'comments', 'comment_id', 'post_comments.php?id=' .  escape( $_GET['id']) . '');
        }
    }
}

//============ END COMMENT RELATED HELPER  =============//







//================ USER RELATED HELPER  ================//

// ----------------------------------------------//
//  This function is for bulking option in user  //
// ----------------------------------------------//
function bulking_option_user($checBoxArray, $bulk_choices)
{
	global $connection;

    foreach ($_POST['checkBoxArray'] as $userValueId) {
        $bulk_options = escape($_POST['bulk_options']);

        switch ($bulk_options) {
            case 'Admin':
                $update_to_admin = query("UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$userValueId} ");
                break;

            case 'Subscriber':
                $update_to_subscriber = query("UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$userValueId} ");
                break;

            case 'Delete':
                $update_to_delete_status = query("DELETE FROM users WHERE user_id = {$userValueId} ");
                break;  

        }
    }
}


// ---------------------------------------//
//  This function is for viewing all user //
// ---------------------------------------//
function find_all_user()
{
	global $connection;

    //find all posts query

    $select_users = query("SELECT * FROM users "); //select all from table posts 

    while ($row = mysqli_fetch_assoc($select_users)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $user_id = escape($row['user_id']);
        $Username = escape($row['username']);
        $user_password = escape($row['user_password']);
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $user_image = $row['user_image'];
        $user_role = escape($row['user_role']);

        echo "<tr>";
        ?>
            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $user_id ?>"></td>
        <?php
        echo "<td> $user_id  </td>";
        echo "<td> $Username </td>";
        echo "<td> $user_firstname </td>";
        echo "<td> $user_lastname </td>";
        echo "<td> $user_email </td>";
        echo "<td> $user_role </td>";


        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
        echo "<td><a class='btn btn-warning' href='users.php?change_to_admin={$user_id}' title='Change Role'> <i class='fa fa-user' ></i> Admin</a></td>";
        echo "<td><a class='btn btn-warning' href='users.php?change_to_sub={$user_id}' title='Change Role'><i class='fa fa-users'></i> Subscriber</a></td>";
        echo "<td><a class='btn btn-info' href='users.php?source=edit_user&edit_user=$user_id' title='Edit User'><i class='fa fa-edit'></i> Edit</a></td>";
        ?>
            <form method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <?php echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>'; ?>
            </form>
        <?php
         echo "</tr>";

        // ---------------------------------------------------------//
        //  This function is used in deleting the existing comment  //
        // ---------------------------------------------------------//
        if (isset($_POST['delete'])) {
            delete_option($user_id = $_POST['user_id'], 'users', 'user_id', 'users.php');
        }
    }
}

// ---------------------------------------------//
//  This function is used to change user's role //
// ---------------------------------------------//
function changing_role($request, $role, $path)
{
    global $connection;
 
    if(isLoggedIn())
    {
	    if(is_admin())
	    {
	        $the_user_id =  escape($request);
	        $change_role__query = query("UPDATE users SET user_role = '$role' WHERE user_id = {$the_user_id}");
	        redirect("$path");
	    }
	}
}

// ---------------------------------------------//
//  This function is used to edit user profile  //
// ---------------------------------------------//
function edit_profile($user_firstname, $user_lastname, $username,  $user_email, $user_password)
{
	global $connection;

    if(!empty($user_password))
    {
        $get_user_query = query("SELECT user_password FROM users WHERE username = '{$username}' ");
        $row = fetchRecords($get_user_query);
        $db_user_password = escape($row['user_password']);

        if($db_user_password != $user_password)
        {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        }

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE username = '{$username}'";
        $edit_user_query = query($query);
        confirmQuery($edit_user_query);

        echo "<div class='alert alert-success '>";
        echo "User Updated Successful " . " " . "(<a href='profile.php'>View User Detail</a>)";
        echo "</div>";
    }
}

//============ END USER RELATED HELPER  =============//
?>