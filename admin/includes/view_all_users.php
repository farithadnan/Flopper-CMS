<?php 
    include("delete_modal.php");

    if(isset($_POST['checkBoxArray']))
    {
        foreach ($_POST['checkBoxArray'] as $userValueId) {
            $bulk_options = escape($_POST['bulk_options']);

            switch ($bulk_options) {
                case 'Admin':
                    $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$userValueId} ";
                    
                    $update_to_admin = mysqli_query($connection, $query);
                     confirmQuery($update_to_admin);
                    break;

                case 'Subscriber':
                    $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$userValueId} ";

                    $update_to_subscriber = mysqli_query($connection, $query);
                     confirmQuery($update_to_subscriber);
                    break;

                case 'Delete':

                    $query = "DELETE FROM users WHERE user_id = {$userValueId} ";
                    $update_to_delete_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_delete_status);
                    break;  

            }
        }
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

<?php

    //find all posts query

     $query = "SELECT * FROM users "; //select all from table posts 
     $select_users= mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

    while ($row = mysqli_fetch_assoc($select_users)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $user_id = escape($row['user_id']);
        $Username = escape($row['username']);
        $user_password = escape($row['user_password']);
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $user_image = $row['user_image'];
        $user_role = escape($row['user_role']);
        


        echo "<tr>";
        ?>
            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $user_id ?>"></td>
        <?php
        echo "<td> $user_id  </td>";
        echo "<td> $Username </td>";
        echo "<td> $user_firstname </td>";
        echo "<td> $user_lastname </td>";
        echo "<td> $user_email </td>";
        echo "<td> $user_role </td>";


        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
        echo "<td>                 
                <div class='dropdown'>
                  <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'><i class='fa fa-cogs'></i> Action
                  <span class='caret'></span></button>
                  <ul class='dropdown-menu'>
                    <li><a href='users.php?change_to_admin={$user_id}' title='Change Role'> <i class='fa fa-user' ></i> Change: Admin</a></li>
                    <li class='divider'></li>
                    <li><a href='users.php?change_to_sub={$user_id}' title='Change Role'><i class='fa fa-users'></i> Change: Subscriber</a></li>
                    <li class='divider'></li>
                    <li><a href='users.php?source=edit_user&edit_user=$user_id' title='Edit User'><i class='fa fa-edit'></i> Edit</a></li>
                    <li class='divider'></li>                    
                    <li><a rel='$user_id' href='javascript:void(0)' class='delete_link' title='Delete User'><i class='fa fa-trash'></i> Delete</a></li>
                  </ul>
                </div> 
                </td>";
        echo "</tr>";


    }
?> 

</tbody>
</table>
</form>


<?php 
if (isset($_GET['change_to_admin'])) { //dia hantar comment id; using get, approve=$comment_id same goes for unapproved so dia simpan value comment id kt dalam $_get approve & unapprove

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] =='Admin')
        {
            $the_user_id =  escape( $_GET['change_to_admin']);


            $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = {$the_user_id}";
            $change_to_admin_query = mysqli_query($connection, $query);

            if(!$change_to_admin_query)
            {
                die('QUERY FAILED' . mysqli_error($connection));
            }


            header("Location: users.php");
        }
    }

}





if (isset($_GET['change_to_sub'])) {

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] =='Admin')
        {
            $the_user_id = escape($_GET['change_to_sub']);


            $query = "UPDATE users SET user_role = 'Subscriber'  WHERE user_id = {$the_user_id}";
            $change_to_sub_query = mysqli_query($connection, $query);

            if(!$change_to_sub_query)
            {
                die('QUERY FAILED' . mysqli_error($connection));
            }


            header("Location: users.php");
        }
    }

}







if (isset($_GET['delete'])) {

        if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] =='Admin')
            {
                $the_user_id =escape($_GET['delete']);


                $query = "DELETE FROM  users WHERE user_id = {$the_user_id} ";
                $deleteQuery = mysqli_query($connection, $query);

                if(!$deleteQuery)
                {
                    die('QUERY FAILED' . mysqli_error($connection));
                }


                header("Location: users.php");
            }
        }
    }


 ?>

 <script>

    $(document).ready(function(){

        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "users.php?delete=" + id + " ";


            $(".modal_delete_link").attr("href", delete_url); 

            $("#delModal").modal("show")
        });
    });

</script>