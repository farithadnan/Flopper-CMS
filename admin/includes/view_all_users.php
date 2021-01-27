                        <table class="table table-bordered table-hover table-sm ">
                            <thead>
                                <tr>
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
        $user_id = $row['user_id'];
        $Username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        


        echo "<tr>";
        echo "<td> $user_id  </td>";
        echo "<td> $Username </td>";
        echo "<td> $user_firstname </td>";



        //THIS ONE WILL RELATE THE POST CATEGORY ID FROM TABLE POST WITH CAT ID IN TABLE CATEGORIES
        //  $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
        //  $select_categories_id = mysqli_query($connection, $query); 

        //  while ($row = mysqli_fetch_assoc( $select_categories_id )) { 
        //  $cat_id = $row['cat_id'];
        //  $cat_title = $row['cat_title'];






        // echo "<td> {$cat_title} </td>";

        // }

        echo "<td> $user_lastname </td>";
        echo "<td> $user_email </td>";
        echo "<td> $user_role </td>";

        // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
        // $select_post_id_query = mysqli_query($connection, $query);

        // while ($row = mysqli_fetch_assoc($select_post_id_query)) {
        //     $post_id = $row['post_id'];
        //     $post_title = $row['post_title'];

        //     echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";

        // }

        


        //source=edit_post is to get user go to the edit post page, while p_id = post id is to stored the the id of the post, & is used if u wanted to set more than one parameter when using $_GET 
        echo "<td><a href='users.php?change_to_admin={$user_id}'> <button class='btn btn-success'><i class='fa fa-check'></i> Admin</button></a></td>";
        echo "<td><a href='users.php?change_to_sub={$user_id}'> <button class='btn btn-warning'><i class='fa fa-times'></i> Subscriber</button></a></td>";
        echo "<td><a href='users.php?delete=$user_id'> <button class='btn btn-danger'><i class='fa fa-trash'></i> Delete</button></a></td>";
        echo "<td><a href='users.php?source=edit_user&edit_user=$user_id'> <button class='btn btn-info'><i class='fa fa-edit'></i> Edit</button></a></td>";
        echo "</tr>";


    }
                                  ?> 

                            </tbody>
                        </table>


<?php 
if (isset($_GET['change_to_admin'])) { //dia hantar comment id; using get, approve=$comment_id same goes for unapproved so dia simpan value comment id kt dalam $_get approve & unapprove
        $the_user_id = $_GET['change_to_admin'];


        $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = $the_user_id";
        $change_to_admin_query = mysqli_query($connection, $query);

        if(!$change_to_admin_query)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


        header("Location: users.php");
    }





if (isset($_GET['change_to_sub'])) {
        $the_user_id = $_GET['change_to_sub'];


        $query = "UPDATE users SET user_role = 'Subscriber'  WHERE user_id = $the_user_id";
        $change_to_sub_query = mysqli_query($connection, $query);

        if(!$change_to_sub_query)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


        header("Location: users.php");
    }







if (isset($_GET['delete'])) {
        $the_user_id = $_GET['delete'];


        $query = "DELETE FROM  users WHERE user_id = {$the_user_id} ";
        $deleteQuery = mysqli_query($connection, $query);

        if(!$deleteQuery)
        {
            die('QUERY FAILED' . mysqli_error($connection));
        }


        header("Location: users.php");
    }





 ?>