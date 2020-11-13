<?php 


	if (isset($_GET['p_id'])) {
		$the_post_id = $_GET['p_id']; 



    $query = "SELECT * FROM posts "; //select all from table posts 
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
		<input type="text" class="form-control" name="post_category_id" value="<?php echo $post_category_id; ?>">
	</div>	

	<div class="form-group">
		<label for="author">Post Author</label>
		<input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<input type="text" class="form-control" name="post_status" value="<?php echo $post_status; ?>">
	</div>

	<div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" class="form-control" name="image" value="<?php echo $post_title; ?>">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags" value="<?php echo $post_tag; ?>">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Content</label>
		<textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10" >
			<?php echo $post_content; ?>
		</textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary " name="create_post" value=" Update Post">
	</div>

</form>