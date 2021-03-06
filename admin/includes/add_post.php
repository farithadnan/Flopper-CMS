<?php 

if (isset($_POST['create_post'])) {

	$post_title = escape($_POST['title']);
	$post_user = escape($_POST['post_user']); // this post user is a user that actually have been created in the system
	$post_category_id = escape($_POST['post_category']);
	$post_status = escape($_POST['post_status']);


	//user superglobal $_FILES to send data thru post
	$post_image = $_FILES['image']['name']; // image the name of the file 
	$post_image_temp = escape($_FILES['image']['tmp_name']); // temporary info of the files, when previewing the name of the file, this also needed to be transfer

	$post_tags = escape($_POST['post_tags']);
	$post_content = escape($_POST['post_content']);
	$post_date = date('d-m-y'); //using default date function, with a format to capture date


	move_uploaded_file($post_image_temp, "../images/$post_image"); //to move file to the desired location in query below it only stored the file name not its location.


	$query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tag,  post_status) ";

	$query .= "VALUES({$post_category_id},'$post_title','$post_user', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')"; //stored the latest date using now() function

	$create_post_query = mysqli_query($connection, $query);

	 confirmQuery($create_post_query);

	 $the_post_id = mysqli_insert_id($connection); //this function will extract the latest post id we entered

	 echo "<div class='alert alert-success '>";
	 echo "Post Created Successful " . " " . "(<a href='../post.php?p_id={$the_post_id}'>View Post</a> | <a href='posts.php'>Edit More Post</a> )";
	 echo "</div>";
}
 ?>

<!-- enctype multipart/form-data is require if u want to send file thru post-->
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title" placeholder="Enter Post Title">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category</label>

		<select class="form-control" name="post_category" id="post_category">
		<option value="">Select an option</option>
<?php 


     $query = "SELECT * FROM categories";
     $select_categories = mysqli_query($connection, escape($query)); 

     confirmQuery($select_categories);

     while ($row = mysqli_fetch_assoc( $select_categories)) { 
     $cat_id = escape($row['cat_id']);
     $cat_title = escape($row['cat_title']);

     	echo "<option value='{$cat_id}'>{$cat_title}</option>";


	 }

 ?>

		</select>
	</div>	

	<div class="form-group">
		<label for="post_user">Post Author</label>

		<select class="form-control" name="post_user" id="post_user">
		<option value="">Select Author</option>
<?php 


     $users_query = "SELECT * FROM users";
     $select_users = mysqli_query($connection, escape($users_query)); 

     confirmQuery($select_users);

     while ($row = mysqli_fetch_assoc($select_users)) { 
     $user_id = escape($row['user_id']);
     $username = escape($row['username']);

     	echo "<option value='{$username}'>{$username}</option>";


	 }

 ?>

		</select>
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select class="form-control" name="post_status">
			<option value="Draft">Select an option</option>
			<option value="Published">Publish</option>
			<option value="Draft">Draft</option>
		</select>
	</div>

	<div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" class="form-control" name="image">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags" placeholder="Enter Post Tags">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Content</label>
		<textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="20">
		</textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
	</div>

</form>