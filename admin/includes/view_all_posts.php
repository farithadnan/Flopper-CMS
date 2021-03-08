<?php 

    include("delete_modal.php");

    //this post global is for making sure, that the bulk options that user pick for the post status could be updated here  
    if(isset($_POST['checkBoxArray']))
    {
        bulking_option_post($checBoxArray = $_POST['checkBoxArray'], $bulk_choices = $_POST['bulk_options']);
    }
 ?>

<form action="" method="post">
<table class="table table-bordered table-hover table-sm ">


    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Published">Publish</option>
            <option value="Draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
            <option value="reset">Reset Views Count</option>
        </select>
    </div>

    <div id="bulkOptionsButton" class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success " value="Apply" title="Apply Bulk Action">
        <a class="btn btn-primary" href="posts.php?source=add_post" title="Add New Post"><i class="fa fa-plus"></i> Add New</a>
    </div> 
        <br>

    <thead>
        <tr>
            <th><input  type="checkbox" id="selectAllBoxes" name="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author (Users)</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Views Count</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php view_all_post(); ?> 
    </tbody>
</table>
</form>

<?php 

// ------------------------------------//
//  Function for delete post  in post  //
// -------- ---------------------------//
if (isset($_POST['delete'])) {
    delete_option($post_id = $_POST['post_id'], 'posts', 'post_id', 'posts.php');
}

// ---------------------------------------//
//  Function for reset view count in post //
// -------- ------------------------------//
if (isset($_GET['reset'])) {
    reset_option($reset = $_GET['reset']);
}
 ?>

<script>
// ----------------------------------------------------------------------//
//  Function for pop out delete modal after user clicking delete button  //
// ---------------------------------------------------------------------//
    $(document).ready(function(){

        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";


            $(".modal_delete_link").attr("href", delete_url); 

            $("#delModal").modal("show")
        });
    });

</script>