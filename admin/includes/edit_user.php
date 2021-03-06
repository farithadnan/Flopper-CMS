  <?php 


if(isset($_GET['edit_user']))
{

	if(isset($_SESSION['user_role']))
	{
	    if($_SESSION['user_role'] == 'Admin')
	    {
			$the_user_id =escape($_GET['edit_user']);
			$query = "SELECT * FROM users WHERE user_id = $the_user_id"; //select all from table posts 
			$select_users_query= mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

			while ($row = mysqli_fetch_assoc($select_users_query)) 
			{ //amek and tukarkan column kepada key, and anak2 column as value dia s
			$user_id = escape($row['user_id']);
			$username = escape($row['username']);
			$user_password = escape($row['user_password']);
			$user_firstname = escape($row['user_firstname']);
			$user_lastname = escape($row['user_lastname']);
			$user_email = escape($row['user_email']);
			$user_image = $row['user_image'];
			// $user_role = $row['user_role'];
			}
		        

			if (isset($_POST['edit_user'])) {


				$user_firstname = escape($_POST['user_firstname']);
				$user_lastname = escape($_POST['user_lastname']);
				// $user_role = $_POST['user_role'];

				//user superglobal $_FILES to send data thru post
				// $post_image = $_FILES['image']['name']; // image the name of the file 
				// $post_image_temp = $_FILES['image']['tmp_name']; // temporary info of the files, when previewing the name of the file, this also needed to be transfer

				$username = escape($_POST['username']);
				$user_email = escape($_POST['user_email']);
				$user_password = escape($_POST['user_password']);
				// $post_date = date('d-m-y'); //using default date function, with a format to capture date


				if (!empty($user_password)) {

					$query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id ";
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
					// $query .= "user_role = '{$user_role}', ";
					$query .= "username = '{$username}', ";
					$query .= "user_email = '{$user_email}', ";
					$query .= "user_password = '{$hashed_password}' ";
					$query .= "WHERE user_id = {$the_user_id}";


					$edit_user_query = mysqli_query($connection, $query);
					confirmQuery($edit_user_query);

					echo "<div class='alert alert-success '>";
					echo "User Updated Successful " . " " . "(<a href='users.php'>View User Detail</a>)";
					echo "</div>";
				}

			}     
	    }
	}
} else {
	header("Location: index.php");
}
?>

<!-- enctype multipart/form-data is require if u want to send file thru post-->
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname?>" required>
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" class="form-control" name="user_lastname" id="user_lastname" value="<?php echo $user_lastname?>" required>
	</div>


	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" id="username" value="<?php echo $username?>" required>
	</div>

	<div class="form-group">
		<label for="post_tags">Email</label>
		<input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email?>" required>
	</div>

	<div class="form-group">
		<label for="post_tags">Password</label>
		<input autocomplete="off" type="password" class="form-control" name="user_password" id="user_password" required>
	</div>


	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
	</div>

</form>