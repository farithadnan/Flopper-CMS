<?php 

    //this post global is for making sure, that the bulk options that user pick for the post status could be updated here  
    if(isset($_POST['checkBoxArray']))
    {
        foreach ($_POST['checkBoxArray'] as $postValueId) {
            $bulk_options = $_POST['bulk_options'];

            switch ($bulk_options) {
                case 'Published':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                    
                    $update_to_published_status = mysqli_query($connection, $query);
                     confirmQuery($update_to_published_status);
                    break;

                case 'Draft':
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                    
                    $update_to_draft_status = mysqli_query($connection, $query);
                     confirmQuery($update_to_draft_status);
                    break;

                case 'delete':

                    $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                    $update_to_delete_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_delete_status);
                    break;  

                case 'clone':

                    $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                    $select_post_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_array($select_post_query)) {
                        $post_author = $row['post_author'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tag = $row['post_tag'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                    }

                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tag,  post_status) ";

                    $query .= "VALUES({$post_category_id},'$post_title','$post_author', now(),'{$post_image}','{$post_content}','{$post_tag}','{$post_status}')";

                    $copy_query = mysqli_query($connection, $query);
                    confirmQuery($copy_query);
                    break;  


                case 'reset':
                    $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $postValueId) . "";
                    $reset_views_count = mysqli_query($connection, $query);
                     confirmQuery($reset_views_count);
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
            <option value="Published">Publish</option>
            <option value="Draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
            <option value="reset">Reset Views Count</option>
        </select>
    </div>

    <div id="bulkOptionsButton" class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
    </div> <br>


    <thead>
        <tr>
            <th><input  type="checkbox" id="selectAllBoxes" name="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Views Count</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>

    <?php

    //find all posts query

     $query = "SELECT * FROM posts ORDER BY post_id DESC"; //select all from table posts 
     $select_posts = mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

    while ($row = mysqli_fetch_assoc($select_posts)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_view_count = $row['post_view_count'];

        echo "<tr>";
        ?>
            <td><input class="checkBoxes" type="checkbox"  name="checkBoxArray[]" value="<?php echo $post_id ?>"></td>
        <?php
        echo "<td> $post_id </td>";
        echo "<td> $post_author </td>";
        echo "<td> $post_title </td>";



        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
         $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
         $select_categories_id = mysqli_query($connection, $query); 

         while ($row = mysqli_fetch_assoc( $select_categories_id )) { 
         $cat_id = $row['cat_id'];
         $cat_title = $row['cat_title'];






        echo "<td> {$cat_title} </td>";

        }

        echo "<td> $post_status </td>";
        echo "<td><img class='img-responsive' width='100' src='../images/$post_image' alt='images'>  </td>";
        echo "<td> $post_tag </td>";
        echo "<td> <i class='fa fa-comments'></i> $post_comment_count </td>";
        echo "<td> $post_date</td>";
        echo "<td> <i class='fa fa-user'></i> <a href='posts.php?reset={$post_id}'>$post_view_count</a> </td>";

        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
       echo "<td>
                <a class='btn btn-info' href='../post.php?p_id={$post_id}'> <i class='fa fa-eye'></i> View</a>

                <a class='btn btn-primary' href='posts.php?source=edit_post&p_id={$post_id}'> <i class='fa fa-pencil'></i> Edit</a> 

                <a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" class='btn btn-danger' href='posts.php?delete={$post_id}'> <i class='fa fa-trash'></i> Delete</a></td>";
     
        
        echo "</tr>";



    }
    ?> 

        </tbody>
    </table>
    </form>

<?php 

if (isset($_GET['delete'])) {
        $the_post_id = $_GET['delete'];


        $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
        $deleteQuery = mysqli_query($connection, $query);

        if(!$deleteQuery)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


         header("Location: posts.php");
    }

if (isset($_GET['reset'])) {
        $the_post_id = $_GET['reset'];


        $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $the_post_id) . "";
        $resetQuery = mysqli_query($connection, $query);

        if(!$resetQuery)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


         header("Location: posts.php");
    }





 ?>