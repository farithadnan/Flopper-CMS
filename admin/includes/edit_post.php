<?php 


	if (isset($_GET['p_id'])) {
		$the_post_id = $_GET['p_id']; 
	}

	//query to preview the choosen post info based on id
    $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}"; //select all from table posts 
    $select_posts_by_id = mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

    while ($row = mysqli_fetch_assoc($select_posts_by_id)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_content = $row['post_content'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];

	}


	//query for submitting edit

	if (isset($_POST['update_post'])) {
	

		$post_title = $_POST['title'];
		$post_author = $_POST['author'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];
		$post_image = $_FILES['image']['name']; 
		$post_image_temp = $_FILES['image']['tmp_name'];
		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];

		move_uploaded_file($post_image_temp, "../images/$post_image"); 


		//below is used to prevent the form from uploading a NULL to post_image in db, if the user doesn't want to update the image
		if (empty($post_image)) {
			$query = "SELECT * FROM posts WHERE post_id = $the_post_id ";

			$select_post_image = mysqli_query($connection, $query);

			while($row = mysqli_fetch_assoc($select_post_image)){
				$post_image = $row['post_image'];

			}
		}


		$query = "UPDATE posts SET ";
		$query .= "post_title = '{$post_title}', ";
		$query .= "post_category_id = '{$post_category_id}', ";
		$query .= "post_date = now(), ";
		$query .= "post_author = '{$post_author}', ";
		$query .= "post_status = '{$post_status}', ";
		$query .= "post_tag = '{$post_tags}', ";
		$query .= "post_content = '{$post_content}', ";
		$query .= "post_image = '{$post_image}' ";
		$query .= "WHERE post_id = {$the_post_id}";


		$update_post = mysqli_query($connection, $query);
		confirmQuery($update_post);
		echo "<div class='alert alert-success '>";
		echo "Your post has been succesfully updated. " . " " . "(<a href='../post.php?p_id={$the_post_id}'>View Post</a> | <a href='posts.php'>Edit More Post</a> )";
		echo "</div>";
	}



 ?>



<!-- enctype multipart/form-data is require if u want to send file thru post-->
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category</label>

		<select class="form-control" name="post_category" id="post_category">
<?php 
     $queryOption = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
     $select_categories_option = mysqli_query($connection, $queryOption ); 

     confirmQuery($select_categories_option);

     while ($row_option = mysqli_fetch_assoc($select_categories_option)) { 
     $cat_id_option = $row_option['cat_id'];
     $cat_title_option = $row_option['cat_title'];

     	echo "<option value='{$cat_id_option}'>{$cat_title_option}</option>";

	 }
	
     $query = "SELECT * FROM categories WHERE cat_id != {$post_category_id}";
     $select_categories = mysqli_query($connection, $query); 

     confirmQuery($select_categories);

     while ($row = mysqli_fetch_assoc($select_categories)) { 
     $cat_id = $row['cat_id'];
     $cat_title = $row['cat_title'];

     	echo "<option value='{$cat_id}'>{$cat_title}</option>";

	 }
 ?>

		</select>
	</div>	

	<div class="form-group">
		<label for="author">Post Author</label>
		<input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select class="form-control" name="post_status" id="post_status">
		<option value="<?php echo $post_status ?>"><?php  echo $post_status; ?></option>
		<?php 
			if($post_status == 'Published')
			{
				echo "<option value='Draft'>Draft</option>";
			}
			else
			{
				echo "<option value='Published'>Published</option>";
			}
		 ?>
		</select>
	</div>


	<div class="form-group">
	<img width="100" src="../images/<?php echo  $post_image; ?>">
	<br>
	<label for="image">Post Image</label>
	<input type="file" class="form-control" name="image" value="<?php echo $post_title; ?>">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags" value="<?php echo $post_tag; ?>">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Content</label>
		<textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10" ><?php echo $post_content; ?></textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary " name="update_post" value=" Update Post">
	</div>

</form>