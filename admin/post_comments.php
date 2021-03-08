<?php include("includes/admin_header.php"); ?>

<div id="wrapper">
 <!-- Navigation -->
<?php include("includes/admin_navigation.php"); ?>


<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">

                <h1 class="page-header">
                    Welcome to <?php echo $_SESSION['user_role']; ?>
                    <small><?php echo $_SESSION['username']; ?></small>
                </h1>   

<?php 

    //this post global is for making sure, that the bulk options that user pick for the post status could be updated here  
    if(isset($_POST['checkBoxArray']))
    {
        bulking_option_post_comment($checBoxArray = $_POST['checkBoxArray'], $bulk_choices = $_POST['bulk_options']);
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
        <input type="submit" name="submit" class="btn btn-success" value="Apply" title="Apply Bulk Action">
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
        <?php find_all_post_comment(); ?> 
    </tbody>
</table>
</form>

<?php 
    // ---------------------------------------//
    //  Function for approving the comment    //
    // -------- ------------------------------//
    if (isset($_GET['approve'])) {
        comment_approval($approve = $_GET['approve'], 'Approved', ' post_comments.php?id=' .  escape( $_GET['id']) . ''); 
    }

    // -----------------------------------------//
    //  Function for unapproving the comment    //
    // -------- --------------------------------//
    if (isset($_GET['unapprove'])) {
        comment_approval($unapprove = $_GET['unapprove'], 'Unapproved', ' post_comments.php?id=' .  escape( $_GET['id']) . '');   
    }

?>
             </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</div>

<?php include("includes/admin_footer.php"); ?>