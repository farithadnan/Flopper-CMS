
<?php include("includes/header.php"); ?>

    <!-- Navigation -->
<?php include("includes/nav.php"); ?>

<?php  

// ---------------------------------//
//  Executing post request for like //
// ---------------------------------//
    if(isset($_POST['liked'])){

        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        // 1. FETCHING THE POST FROM THE DB AND THE POST'S DATA
        $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];

        if(mysqli_num_rows($postResult) >= 1)
        {
            echo $post['post_id'];
        }

        // 2. UPDATE INCREMENTING WITH LIKES
        mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id={$post_id}");

        // 3. PUT DATA INTO LIKES
        mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES({$user_id}, {$post_id})");
        exit();
    }


// -----------------------------------//
//  Executing post request for unlike //
// -----------------------------------//
    if(isset($_POST['unliked'])){

        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        // 1. FETCHING THE POST 
        $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];

        // 2. DELETE LIKES
        mysqli_query($connection, "DELETE FROM likes WHERE post_id={$post_id} AND user_id={$user_id}");

        // 3. UPDATE DECREMENTING WITH LIKE
        mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id={$post_id}");
        exit();
    }



?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">


                <?php 

                if(isset($_GET['p_id'])){

                $the_post_id = $_GET['p_id'];

                $check = query("SELECT * FROM posts WHERE post_id = {$the_post_id} AND user_id =".loggedInUserId()."");
                $fetch = count_records($check);
                $row = fetchRecords($check);
                $status = $row['post_status'];

                if($fetch == 0)
                {
                    redirect("index");
                }
                $update_statement = mysqli_prepare($connection, "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = ?");
                mysqli_stmt_bind_param($update_statement, "i", $the_post_id);
                mysqli_stmt_execute($update_statement);
                confirmQuery($update_statement);

                if (isLoggedIn()) {

                    $stmt1 = mysqli_prepare($connection, "SELECT post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_id = ? AND post_user = ?");

                }
                else {
                    redirect("index");
                    // $stmt2 = mysqli_prepare($connection , "SELECT post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_id = ? AND post_status = ? ");
                    // $published = 'Published';
                }

                if(isset($stmt1)){

                    mysqli_stmt_bind_param($stmt1, "is", $the_post_id, $_SESSION['username']);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_title, $post_user, $post_date, $post_image, $post_content);

                    $stmt = $stmt1;

                }
                // else {
                //     mysqli_stmt_bind_param($stmt2, "is", $the_post_id, $published);
                //     mysqli_stmt_execute($stmt2);
                //     mysqli_stmt_bind_result($stmt2, $post_title, $post_author, $post_date, $post_image, $post_content);
                //     $stmt = $stmt2;
                // }

                while(mysqli_stmt_fetch($stmt)) {
                ?>


                    <h1 class="page-header">
                        <span class="glyphicon glyphicon-bookmark"></span> Post 
                        <?php
                            if($fetch != 0)
                            {
                                echo "<div class='pull-right '><small class='text text-warning'> ". $status."</small></div>";
                            }
                        ?>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $post_title ?></a> 
                    </h2>
                    <p class="lead">
                        by <a href="/project/cms/index"><?php echo ucfirst($post_user); ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted <?php echo $post_date; ?></p>
                    <hr>
                <img class="img-responsive" src="/project/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt=""> <!-- it get data (img link) from db, it has been entered manually by me -->
                    <hr>
                    <p><?php echo $post_content ?></p>

                    <hr>

       <?php

            // FREEING RESULT
            mysqli_stmt_free_result($stmt);

        ?>
                    <?php  
                        if(isLoggedIn()){ 
                    ?>

                        <div class="row">
                            <p class="pull-right">
                                <a class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'; ?>" href="">
                                    <span class="glyphicon glyphicon-thumbs-up" data-toggle="tooltip" data-placement="top" title="<?php echo userLikedThisPost($the_post_id) ? ' I liked this before' : ' Want to like it?'; ?>"></span>
                                        <?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like'; ?>
                                </a>
                            </p>
                        </div>

                    <?php } else { ?>

                        <div class="row">
                            <p class="pull-right">You need to <a href="/project/cms/login">login</a> to like this post.</p>
                        </div>

                    <?php } ?>

                    <div class="row">
                        <small class="pull-right"><i class="glyphicon glyphicon-user"></i> <?php getPostLikes($the_post_id); ?> people like this.</small>
                    </div>
                    <br>
                    <div class="clearfix">
                    </div>

                <!-- While loop end -->
                <?php  } ?>
               
            

                <!-- Blog Comments -->
                <?php 
                    $message = '';
                    if(isset($_POST['create_comment']))
                    {


                        $the_post_id = $_GET['p_id']; //using the post id in the url
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";

                            $query .= " VALUES ( $the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now() )";

                            $create_comment_query = mysqli_query($connection, $query);

                            confirmQuery($create_comment_query);


                            //query for comment count
                            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1";
                            $query .= " WHERE post_id = $the_post_id";
                            $update_comment_count = mysqli_query($connection, $query);

                             $message = "<div class='alert alert-success'>";
                             $message .=  "Your comment has been successfully submitted ";
                             $message .= "</div>";
                            
                        }

                        else
                        {
                             $message = "<div class='alert alert-danger'>";
                             $message .=  "Field can't be empty. Please try again. ";
                             $message .= "</div>";
                        }
                    }

                 ?>

                <!-- Comments Form -->
                <div class="well">
                    
                    <h3><span class="glyphicon glyphicon-envelope"></span> Leave a Comment:</h3>
                   <?php echo $message; ?>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="comment_author">Name</label>
                            <input type="text" class="form-control" name="comment_author" placeholder="Please enter your name">
                        </div>
                        <div class="form-group">
                            <label for="comment_author">Email</label>
                            <input type="email" class="form-control" name="comment_email" placeholder="Please enter your email">
                        </div>
                        <div class="form-group">
                             <label for="comment_content">Your Comment</label>

                            <textarea name="comment_content" class="form-control" rows="3" placeholder="Please enter your comment"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary" title="Submit your comment"><span class="glyphicon glyphicon-pencil"></span> Submit</button>
                    </form>
                </div>

                <br>
                <!-- Posted Comments -->
                <h1><span class="glyphicon glyphicon-comment"></span> Comments</h1>
                <hr>
<?php 

    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id}";
    $query .= " AND comment_status = 'Approved'";
    $query .= " ORDER BY comment_id DESC ";
    $select_comment_query = mysqli_query($connection, $query);

    confirmQuery($select_comment_query);

    if(mysqli_num_rows($select_comment_query) <1 )
    {
         echo "<div class='alert alert-info'>";
         echo " Comments is not yet available. ";
         echo "</div>";
    }

    while ($row = mysqli_fetch_array($select_comment_query)) {
        $comment_date = $row['comment_date'];
        $comment_content = $row['comment_content'];
        $comment_author = $row['comment_author'];

?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author ?>
                            <small><?php echo $comment_date ?></small>
                        </h4>
                       <?php echo $comment_content ?>
                    </div>
                </div>



        <?php }

         }  else {
                  redirect("index");
                } 
        ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>

        </div>
        <!-- /.row -->
</div>
        <br>
        <hr>

   <?php include("includes/footer.php"); ?>

   <script>

    // -------------------------//
    //  post function with Ajax //
    // -------------------------//
    
    $(document).ready(function(){

         // Tooltip function
        $("[data-toggle='tooltip']").tooltip();

        var post_id = <?php echo $the_post_id; ?>;
        var user_id = <?php echo loggedInUserId(); ?>;

        // LIKE POST AJAX
        $('.like').click(function(){
            $.ajax({
                url : "/project/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }

            });
        });

        // UNLIKE POST AJAX
        $('.unlike').click(function(){
            $.ajax({
                url : "/project/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }

            });
        });
    });

   </script>