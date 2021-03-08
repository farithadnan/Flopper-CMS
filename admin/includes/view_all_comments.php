<?php 
    include("delete_modal.php");
    //this post global is for making sure, that the bulk options that user pick for the post status could be updated here  
    if(isset($_POST['checkBoxArray']))
    {
        bulking_option_comment($checBoxArray = $_POST['checkBoxArray'], $bulk_choices = $_POST['bulk_options']);
    }
 ?>


<form action="" method="post">
<table class="table table-bordered table-hover table-sm ">


    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Approved">Approve</option>
            <option value="Unapproved">Unapprove</option>
            <option value="Delete">Delete</option>
        </select>
    </div>

    <div id="bulkOptionsButton" class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply" title="Apply Bulk Option">
    </div> 
    <br>


    <thead>
        <tr>
            <th><input  type="checkbox" id="selectAllBoxes" name="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php find_all_comment();?> 
    </tbody>
</table>
</form>



<?php 
    // ---------------------------------------//
    //  Function for approving the comment    //
    // -------- ------------------------------//
    if (isset($_GET['approve'])) {
        comment_approval($approve = $_GET['approve'], 'Approved', 'comments.php'); 
    }

    // ---------------------------------------//
    //  Function for unapproving the comment  //
    // -------- ------------------------------//
    if (isset($_GET['unapprove'])) {
        comment_approval($unapprove = $_GET['unapprove'], 'Unapproved', 'comments.php'); 
    }
?>

<script>
// ----------------------------------------------------------------------//
//  Function for pop out delete modal after user clicking delete button  //
// ---------------------------------------------------------------------//
    $(document).ready(function(){

        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "comments.php?delete=" + id + " ";

            $(".modal_delete_link").attr("href", delete_url); 

            $("#delModal").modal("show")
        });
    });

</script>