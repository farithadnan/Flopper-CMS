                        <table class="table table-bordered table-hover table-sm ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapproved</th>
                                    <th>Delete</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php

    //find all posts query

     $query = "SELECT * FROM comments "; //select all from table posts 
     $select_comments= mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

    while ($row = mysqli_fetch_assoc($select_comments)) 
    { //amek and tukarkan column kepada key, and anak2 column as value dia s
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row['comment_email'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];


        echo "<tr>";
        echo "<td> $comment_id  </td>";
        echo "<td> $comment_author </td>";
        echo "<td> $comment_content </td>";



        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
        //  $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
        //  $select_categories_id = mysqli_query($connection, $query); 

        //  while ($row = mysqli_fetch_assoc( $select_categories_id )) { 
        //  $cat_id = $row['cat_id'];
        //  $cat_title = $row['cat_title'];






        // echo "<td> {$cat_title} </td>";

        // }

        echo "<td> $comment_email </td>";
        echo "<td> $comment_status </td>";
        echo "<td> som title </td>";
        echo "<td> $comment_date </td>";

        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
        echo "<td><a href='posts.php?source=edit_post&p_id='> <button class='btn btn-success'><i class='fa fa-check'></i> Approve</button></a></td>";
        echo "<td><a href='posts.php?delete='> <button class='btn btn-warning'><i class='fa fa-times'></i> Unapproved</button></a></td>";
        echo "<td><a href='posts.php?delete='> <button class='btn btn-danger'><i class='fa fa-trash'></i> Delete</button></a></td>";
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
    }





 ?>