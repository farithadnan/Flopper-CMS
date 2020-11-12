<!-- enctype multipart/form-data is require if u want to send file thru post-->
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category</label>
		<input type="text" class="form-control" name="post_category_id">
	</div>	

	<div class="form-group">
		<label for="author">Post Author</label>
		<input type="text" class="form-control" name="author">
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<input type="text" class="form-control" name="post_status">
	</div>

	<div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" class="form-control" name="image">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Content</label>
		<textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10">
		</textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary " name="create_post" value=" Update Post">
	</div>

</form>