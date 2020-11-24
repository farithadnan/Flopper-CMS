                        <table class="table table-bordered table-hover table-sm ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th colspan="2">Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php

    //find all posts query

     $query = "SELECT * FROM posts "; //select all from table posts 
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

        echo "<tr>";
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
        echo "<td> $post_comment_count </td>";
        echo "<td> $post_date</td>";

        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'> <button class='btn btn-primary'><i class='fa fa-pencil'></i> Edit</button></a> <a href='posts.php?delete={$post_id}'> <button class='btn btn-danger'><i class='fa fa-trash'></i> Delete</button></a></td>";
        
        echo "</tr>";


    }
                                  ?> 

                            </tbody>
                        </table>


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





 ?>