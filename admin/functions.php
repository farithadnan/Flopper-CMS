<?php 

// ----------------------------------------------------------//
//  Function that wil redirect user to a specified path      //
// ----------------------------------------------------------//
function redirect($location)
{
	return header("Location:" . $location);
}

// ----------------------------------------------------------//
//  Function that is used to do filtration from a user input //
// ----------------------------------------------------------//
function escape($string) {

	global $connection;

	return mysqli_real_escape_string($connection, trim($string));
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

		    $query = "SELECT * FROM user_online WHERE session = '$session'";
		    $send_query = mysqli_query($connection, $query);
		    $count = mysqli_num_rows($send_query);

			    if($count == NULL)
			    {
			        mysqli_query($connection, "INSERT INTO user_online(session, time_log) VALUES('$session','$time') ");
			    }
			    else 
			    {

			        mysqli_query($connection, "UPDATE user_online SET time_log = '$time' WHERE session = '$session' ");
			    }

		    $user_online_query = mysqli_query($connection, "SELECT * FROM user_online WHERE time_log > '$time_out'");
		    echo $count_user = mysqli_num_rows($user_online_query);	

			}

	} //get request isset
}
users_online();


// -----------------------------------------------------------------------------------//
//  Query Checker function, this will determine wheteher the query is executed or not //
// -----------------------------------------------------------------------------------//
function confirmQuery($result) {

	global $connection;

	if (!$result) {
		die('QUERY FAILED ' . mysqli_error($connection). ' ' . mysqli_errno($connection));
	}

}



// ----------------------------------------------------//
//  Displaying count for card-count in index.php admin //
// ----------------------------------------------------//
function recordCount($table) {

	global $connection;

	 $query = "SELECT * FROM " . $table;
     $select_all = mysqli_query($connection, $query);
     $result = mysqli_num_rows($select_all);

     confirmQuery($result);
     return $result;
}

// ---------------------------------------------------------------------------//
//  Function for checking post status, comment status in index.php admin page //
// ---------------------------------------------------------------------------//
function checkStatus($table, $column, $status) {

	global $connection;

    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($connection, $query);

    confirmQuery($result);

    return mysqli_num_rows($result);
}

// ------------------------------------------------------//
//  Function for checking user role index.php admin page //
// ----------------------------------------------------- //
function checkUserRole($table, $column, $role) {

	global $connection;

	$query = "SELECT * FROM $table WHERE $column = '$role' ";
	$result = mysqli_query($connection, $query);

    confirmQuery($result);
    return mysqli_num_rows($result);

}



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
	        $query = "INSERT INTO categories(cat_title)";
	        $query .="VALUE('{$cat_title}')";
	        $create_category = mysqli_query($connection, $query);

	        confirmQuery($create_category);
	    	}
	}

}


// -------------------------------------------------------------------//
//  This function is used to display all the existing post's category //
// -------------------------------------------------------------------//
function findAllCategories() {

	global $connection;

	//find all categories query

	 $query = "SELECT * FROM categories "; //select all from table categories 
	 $select_categories = mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db



	while ($row = mysqli_fetch_assoc($select_categories)) 
	{ //amek and tukarkan column kepada key, and anak2 column as value dia s
		$cat_id = escape($row['cat_id']);
		$cat_title = escape($row['cat_title']);

		echo"<tr>";
		echo " <td>{$cat_id}</td>";
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
		if(isset($_SESSION['user_role']))
		{
		    if($_SESSION['user_role'] == 'Admin')
		    {
		      $cat_id = escape( $_GET['edit']);
              include "includes/update_categories.php";    
		    }
		}
    }

}


// -----------------------------------------------------------------//
//  This function is used to check if the user role is admin or not //
// -----------------------------------------------------------------//
function is_admin($username){

	global $connection;

	$query = "SELECT user_role FROM users WHERE username = '$username' ";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

	$row = mysqli_fetch_array($result);

	if($row['user_role'] == 'Admin')
	{
		return true;

	} else {

		return false;
	}
}

// -------------------------------------------------------------------------------------------------------------//
//  Function that is used to check whether the username that user inputted already existed in the system or not //
// -------------------------------------------------------------------------------------------------------------//
function username_exists($username)
{
	global $connection;

	$query = "SELECT username FROM users WHERE username = '$username'";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

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

	$query = "SELECT user_email FROM users WHERE user_email = '$email'";
	$result = mysqli_query($connection, $query);
	confirmQuery($result);

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
     
    $username = mysqli_real_escape_string($connection, $username );
    $email    = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));


    $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber')";
    $register_user_query = mysqli_query($connection, $query);

    confirmQuery($register_user_query);

}

// -------------------------------------//
//  Function for executing login query  //
// -------- ----------------------------//
function login_user($username, $password){

	global $connection; 

	$username = trim($username);
	$password =trim($password);

	$username = mysqli_real_escape_string($connection, $username);
	$password = mysqli_real_escape_string($connection, $password);

	$query = "SELECT * FROM users WHERE username = '{$username}'";
	$select_user_query = mysqli_query($connection, $query);

	if(!$select_user_query)
	{
		die("QUERY FAILED" . mysqli_error($connection));
	}

	//fetch assoc; associative array array with define name, and assined value to this name
	//fetch array: numeric array without defined name only define my number like 0,1,2 to store an assign value
	while ($row = mysqli_fetch_array($select_user_query)) 
	{
		$db_id = $row['user_id'];
		$db_username = $row['username'];
		$db_user_password = $row['user_password'];
		$db_user_firstname = $row['user_firstname'];
		$db_user_lastname = $row['user_lastname'];
		$db_user_role = $row['user_role'];

	}

	// $password = crypt($password, $db_user_password );

	if(password_verify($password, $db_user_password))
	{
		$_SESSION['username'] = $db_username;
		$_SESSION['firstname'] = $db_user_firstname;
		$_SESSION['lastname'] = $db_user_lastname;
		$_SESSION['user_role'] = $db_user_role;

		redirect("../admin/index.php");

	} else {

		redirect("/index.php");
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
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                
                $update_to_published_status = mysqli_query($connection, $query);
                 confirmQuery($update_to_published_status);
                break;

            case 'Draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                
                $update_to_draft_status = mysqli_query($connection, $query);
                 confirmQuery($update_to_draft_status);
                break;

            case 'delete':

                $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
                break;  

            case 'clone':

                $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                $select_post_query = mysqli_query($connection, $query);

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

                $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tag,  post_status) ";

                $query .= "VALUES({$post_category_id},'$post_title','$post_user', now(),'{$post_image}','{$post_content}','{$post_tag}','{$post_status}')";

                $copy_query = mysqli_query($connection, $query);
                confirmQuery($copy_query);
                break;  


            case 'reset':
                $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $postValueId) . "";
                $reset_views_count = mysqli_query($connection, $query);
                confirmQuery($reset_views_count);
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

    // $query = "SELECT * FROM posts ORDER BY post_id DESC"; 
    $query = "SELECT posts.post_id, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
    $query .= "posts.post_tag, posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title ";
    $query .= " FROM posts ";
    $query .= " LEFT JOIN categories ON posts.post_category_id =  categories.cat_id";


     $select_posts = mysqli_query($connection, $query);

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
        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
        $send_comment_query = mysqli_query($connection, $query);

        $row = mysqli_fetch_array($send_comment_query);
        $comment_id = isset($row['comment_id']);
        $count_comments = mysqli_num_rows($send_comment_query);

                
        echo "<td> <i class='fa fa-comments'></i><a href='post_comments.php?id=$post_id'> $count_comments</a> </td>";
        echo "<td> $post_date</td>";
        echo "<td> <i class='fa fa-user'></i> <a href='posts.php?reset={$post_id}'>$post_view_count</a> </td>";

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
// -------------------------------------------//
//  Function for single delete option in post //
// -------- ----------------------------------//
function delete_option($id, $table, $column, $page)
{
	global $connection;

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'Admin')
        {
            $the_id =  escape($id);
            $query = "DELETE FROM $table WHERE $column = {$the_id} ";
            $deleteQuery = mysqli_query($connection, $query);

            confirmQuery($deleteQuery);
            redirect("$page");       
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


            $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . escape($the_post_id) . "";
            $resetQuery = mysqli_query($connection, $query);

            confirmQuery($resetQuery);
            redirect("posts.php");
        }
    }
}




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
               $query = "UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ";
                
                $update_to_approve_status = mysqli_query($connection, $query);
                 confirmQuery($update_to_approve_status);
                break;

            case 'Unapproved':
                $query = "UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ";

                $update_to_unapprove_status = mysqli_query($connection, $query);
                 confirmQuery($update_to_unapprove_status);
                break;

            case 'Delete':

                $query = "DELETE FROM comments WHERE comment_id = {$commentValueId} ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
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
    //find all comment query

     $query = "SELECT * FROM comments ORDER BY comment_id DESC"; //select all from table posts 
     $select_comments = mysqli_query($connection, $query);

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
        $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
        $select_post_id_query = mysqli_query($connection, $query);

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

// --------------------------------------------------------------------------------//
//  This function is used in set the comment approval status the existing comment  //
// ----------------------------------------------------------------------------- --//
function comment_approval($approval, $status, $path)
{
	global $connection;

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'Admin')
        {
            $the_comment_id =escape($approval);


            $query = "UPDATE comments SET comment_status = '$status'  WHERE comment_id = {$the_comment_id} ";
            $approveQuery = mysqli_query($connection, $query);

            if(!$approveQuery)
            {
                die('QUERY FAILED' . mysqli_error($connection));
            }
             redirect("$path");        
        }
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
               $query = "UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ";
                
                $update_to_approve_status = mysqli_query($connection, $query);
                 confirmQuery($update_to_approve_status);
                break;

            case 'Unapproved':
                $query = "UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ";

                $update_to_unapprove_status = mysqli_query($connection, $query);
                 confirmQuery($update_to_unapprove_status);
                break;

            case 'Delete':
                $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
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
     $query = "SELECT * FROM comments WHERE comment_post_id =".escape( $_GET['id']) . "" ; 
     $select_comments = mysqli_query($connection, $query);

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
        $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
        $select_post_id_query = mysqli_query($connection, $query);

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
                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$userValueId} ";
                
                $update_to_admin = mysqli_query($connection, $query);
                 confirmQuery($update_to_admin);
                break;

            case 'Subscriber':
                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$userValueId} ";

                $update_to_subscriber = mysqli_query($connection, $query);
                 confirmQuery($update_to_subscriber);
                break;

            case 'Delete':
                $query = "DELETE FROM users WHERE user_id = {$userValueId} ";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
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

     $query = "SELECT * FROM users "; //select all from table posts 
     $select_users= mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

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
    
    if(isset($_SESSION['user_role']))
    {
	    if($_SESSION['user_role'] =='Admin')
	    {
	        $the_user_id =  escape($request);


	        $query = "UPDATE users SET user_role = '$role' WHERE user_id = {$the_user_id}";
	        $change_role__query = mysqli_query($connection, $query);

	        confirmQuery($change_role__query);
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
        $query_password = "SELECT user_password FROM users WHERE username = '{$username}' ";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);

        $row = mysqli_fetch_array($get_user_query);

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


        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);

        echo "<div class='alert alert-success '>";
        echo "User Updated Successful " . " " . "(<a href='profile.php'>View User Detail</a>)";
        echo "</div>";
    }
}


?>