  <?php 


if(isset($_GET['edit_user']))
{
	$the_user_id = $_GET['edit_user'];
	$query = "SELECT * FROM users WHERE user_id = $the_user_id"; //select all from table posts 
	$select_users_query= mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

	while ($row = mysqli_fetch_assoc($select_users_query)) 
	{ //amek and tukarkan column kepada key, and anak2 column as value dia s
	$user_id = $row['user_id'];
	$username = $row['username'];
	$user_password = $row['user_password'];
	$user_firstname = $row['user_firstname'];
	$user_lastname = $row['user_lastname'];
	$user_email = $row['user_email'];
	$user_image = $row['user_image'];
	$user_role = $row['user_role'];
	}
        
}



if (isset($_POST['edit_user'])) {


	$user_firstname = $_POST['user_firstname'];
	$user_lastname = $_POST['user_lastname'];
	$user_role = $_POST['user_role'];

	//user superglobal $_FILES to send data thru post
	// $post_image = $_FILES['image']['name']; // image the name of the file 
	// $post_image_temp = $_FILES['image']['tmp_name']; // temporary info of the files, when previewing the name of the file, this also needed to be transfer

	$username = $_POST['username'];
	$user_email = $_POST['user_email'];
	$user_password = $_POST['user_password'];
	// $post_date = date('d-m-y'); //using default date function, with a format to capture date


	$query = "UPDATE users SET ";
	$query .= "user_firstname = '{$user_firstname}', ";
	$query .= "user_lastname = '{$user_lastname}', ";
	$query .= "user_role = '{$user_role}', ";
	$query .= "username = '{$username}', ";
	$query .= "user_email = '{$user_email}', ";
	$query .= "user_password = '{$user_password}' ";
	$query .= "WHERE user_id = {$the_user_id}";


	$edit_user_query = mysqli_query($connection, $query);
	confirmQuery($edit_user_query);
	 echo "<div class='alert alert-success '>";
	 echo "User Updated Successful " . " " . "(<a href='users.php'>View User Detail</a>)";
	 echo "</div>";
}
 ?>

<!-- enctype multipart/form-data is require if u want to send file thru post-->
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname?>">
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" class="form-control" name="user_lastname" id="user_lastname" value="<?php echo $user_lastname?>">
	</div>

	<div class="form-group">
		<label for="user_role">Role</label>
		<select name="user_role" id="user_role" class="form-control">
		<option value="subscriber"><?php echo $user_role; ?></option>
		<?php 
			if($user_role == 'Admin')
			{
				echo "<option value='Subscriber'>Subscriber</option>";
			} else {
				echo "<option value='Admin'>Admin</option>";
			}
		 ?>
		</select>
	</div>



	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" class="form-control" name="username" id="username" value="<?php echo $username?>">
	</div>

	<div class="form-group">
		<label for="post_tags">Email</label>
		<input type="email" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email?>">
	</div>

	<div class="form-group">
		<label for="post_tags">Password</label>
		<input type="password" class="form-control" name="user_password" id="user_password" value="<?php echo $user_password?>">
	</div>


	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="edit_user" value="Create User">
	</div>

</form>