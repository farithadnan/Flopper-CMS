<?php 
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
	    echo "<td>
	          <div class='dropdown'>
	          <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'><i class='fa fa-cogs'></i> Action
	          <span class='caret'></span></button>
	          <ul class='dropdown-menu'>
	            <li><a href='categories.php?edit={$cat_id}' title='Edit Category'><i class='fa fa-pencil'></i> Edit</a></li>
	            <li class='divider'></li>
	            <li><a rel='$cat_id' href='javascript:void(0)' class='delete_link' title='Delete Category'><i class='fa fa-trash'></i> Delete</a></li>
	          </ul>
	          </div> 
	   	    </td>";
		echo "</tr>";


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


// ---------------------------------------------------------------//
//  This function is used in deleting the existing post Category //
// --------------------------------------------------------------//
function deleteCategories() {

	global $connection;


	//delete query
	//this one will store cat id, from the link after delete=
	if(isset($_GET['delete']))
	{
		if(isset($_SESSION['user_role']))
		{
		    if($_SESSION['user_role'] == 'Admin')
		    {
			    $the_cat_id =escape( $_GET['delete']); 
			    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
			    $delete_query = mysqli_query($connection, $query);
			    header("Location: categories.php");   
		    }
    	}

	}
}



// ---------------------------------------------------------------//
//  This function is used in deleting the existing post Category //
// --------------------------------------------------------------//
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


?>