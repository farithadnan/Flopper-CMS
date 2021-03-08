<?php 
    include("delete_modal.php");

    if(isset($_POST['checkBoxArray']))
    {
        bulking_option_user($checBoxArray = $_POST['checkBoxArray'], $bulk_choices = $_POST['bulk_options']);
    }

 ?>

<form action="" method="post">
<table class="table table-bordered table-hover table-sm ">

    <div id="bulkOptionsContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="Admin">Change to Admin</option>
            <option value="Subscriber">Change to Subscriber</option>
            <option value="Delete">Delete</option>
        </select>
    </div>

    <div id="bulkOptionsButton" class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply" title="Apply Bulk Action">
        <a class="btn btn-primary" href="users.php?source=add_user" title="Add New User"><i class="fa fa-plus"></i> Add New</a>
    </div> 
    <br>

<thead>
    <tr>
        <th><input  type="checkbox" id="selectAllBoxes" name="selectAllBoxes"></th>
        <th>Id</th>
        <th>Username</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>email</th>
        <th>Role</th>
        <th colspan="4">Action</th>
    </tr>
</thead>
<tbody>

<?php find_all_user(); ?> 

</tbody>
</table>
</form>


<?php 
// ----------------------------------//
//  Function for changing user role  //
// -------- -------------------------//
if (isset($_GET['change_to_admin'])) { 
    changing_role($request = $_GET['change_to_admin'], 'Admin', 'users.php');
}

if (isset($_GET['change_to_sub'])) {
    changing_role($request = $_GET['change_to_sub'], 'Subscriber', 'users.php');
}
?>

 <script>
// ----------------------------------------------------------------------//
//  Function for pop out delete modal after user clicking delete button  //
// ---------------------------------------------------------------------//
    $(document).ready(function(){

        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "users.php?delete=" + id + " ";


            $(".modal_delete_link").attr("href", delete_url); 

            $("#delModal").modal("show")
        });
    });

</script>