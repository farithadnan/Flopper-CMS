<?php include "db.php"; ?>
<?php session_start(); ?>

<?php 
	if(isset($_POST['login']))
	{
		 $username = $_POST['username'];
		 $password = $_POST['password'];

		 //this is to make the the data is clean
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

		 	header("Location: ../admin");
		 } else {

		 	header("Location: ../index.php");
		 }

	}
 ?>