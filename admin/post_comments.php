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
                    Welcome to Comments
                    <small>Author</small>
                </h1>   

<?php 

    //this post global is for making sure, that the bulk options that user pick for the post status could be updated here  
    if(isset($_POST['checkBoxArray']))
    {
        foreach ($_POST['checkBoxArray'] as $commentValueId) {
            $bulk_options = escape($_POST['bulk_options']);

            switch ($bulk_options) {
                case 'Approved':
                   $query = "UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ";
                    
                    $update_to_approve_status = mysqli_query($connection, $query);
                     confirmQuery($update_to_approve_status);
                    break;

                case 'Unapproved':
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}'  WHERE comment_id = {$commentValueId} ";

                    $update_to_unapprove_status = mysqli_query($connection, $query);
                     confirmQuery($update_to_unapprove_status);
                    break;

                case 'Delete':

                    $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
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
 <?php

    //find all posts query

     $query = "SELECT * FROM comments WHERE comment_post_id =".escape( $_GET['id']) . "" ; 
     $select_comments = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_comments)) 
    { 
        $comment_id = escape($row['comment_id']);
        $comment_post_id = escape($row['comment_post_id']);
        $comment_author = escape($row['comment_author']);
        $comment_content = escape($row['comment_content']);
        $comment_email = escape($row['comment_email']);
        $comment_status = escape($row['comment_status']);
        $comment_date = escape($row['comment_date']);

        echo "<tr>";
        ?>
            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $comment_id ?>"></td>
        <?php
        echo "<td> $comment_id </td>";
        echo "<td> $comment_author </td>";
        echo "<td> $comment_content </td>";
        echo "<td> $comment_email </td>";
        echo "<td> $comment_status </td>";

        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
        $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id}";
        $select_post_id_query = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_post_id_query)) {
            $post_id = escape($row['post_id']);
            $post_title = escape($row['post_title']);

            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }

        echo "<td> $comment_date </td>";



       echo "<td>
                 <div class='dropdown'>
                  <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'><i class='fa fa-cogs'></i> Action
                  <span class='caret'></span></button>
                  <ul class='dropdown-menu'>
                    <li><a href='post_comments.php?approve={$comment_id}&id=" . $_GET['id'] . "' title='Approve Post'> <i class='fa fa-check'></i> Approve</a></li>
                    <li class='divider'></li>
                    <li><a href='post_comments.php?unapprove={$comment_id}&id=" . $_GET['id'] . "' title='Unapprove Post'><i class='fa fa-times'></i> Unapprove</a></li>
                    <li class='divider'></li>
                    <li><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='post_comments.php?delete={$comment_id}&id=" . $_GET['id'] . "' title='Delete Post'><i class='fa fa-trash'></i> Delete</a></li>
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
    if (isset($_GET['delete'])) {

        if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] == 'Admin')
            {
                $the_comment_id =  escape( $_GET['delete']);


                $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
                $deleteQuery = mysqli_query($connection, $query);

                if(!$deleteQuery)
                {
                    die('QUERY FAILED' . mysqli_error($connection));
                }


                 header("Location: post_comments.php?id=" .  escape( $_GET['id']) . "");       
            }
        }    

    }


    if (isset($_GET['approve'])) {
        if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] == 'Admin')
            {
                $the_comment_id =  escape($_GET['approve']);


                $query = "UPDATE comments SET comment_status = 'Approved'  WHERE comment_id = {$the_comment_id} ";
                $approveQuery = mysqli_query($connection, $query);

                if(!$approveQuery)
                {
                    die('QUERY FAILED' . mysqli_error($connection));
                }


                 header("Location: post_comments.php?id=" .  escape( $_GET['id']) . "");       
            }
        }    

    }


    if (isset($_GET['unapprove'])) {
        if(isset($_SESSION['user_role']))
        {
            if($_SESSION['user_role'] == 'Admin')
            {
                $the_comment_id =  escape($_GET['unapprove']);


                $query = "UPDATE comments SET comment_status = 'Unapproved'  WHERE comment_id = {$the_comment_id} ";
                $unapproveQuery = mysqli_query($connection, $query);

                if(!$unapproveQuery)
                {
                    die('QUERY FAILED' . mysqli_error($connection));
                }


                 header("Location: post_comments.php?id=" .  escape( $_GET['id']) . "");       
            }
        }    

    }

?>














































             </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</div>

<?php include("includes/admin_footer.php"); ?>