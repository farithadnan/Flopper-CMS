
<?php include("includes/header.php"); ?>

    <!-- Navigation -->
<?php include("includes/nav.php"); ?>

    <!-- Page Content --> 
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 

                    if(isset($_GET['category'])){
                        $post_category_id = $_GET['category']; 
                    
                        if (is_admin($_SESSION['username'])) {

                            $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? ");

                            if(isset($stmt2))
                            {
                                mysqli_stmt_bind_param($stmt2, "i", $post_category_id);
                                mysqli_stmt_execute($stmt2);
                                mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

                                $stmt = $stmt2;

                                if (mysqli_stmt_num_rows($stmt) === NULL ) {
                                    echo "<h1 class='text-center'>No posts available. </h1>";
                                }
                            } 
                        }
                        else {

                            $stmt3 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ");

                            $published = 'Published';

                            if(isset($stmt3)){
                                mysqli_stmt_bind_param($stmt3, "is", $post_category_id,  $published );
                                mysqli_stmt_execute($stmt3);
                                mysqli_stmt_bind_result($stmt3, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);

                                $stmt = $stmt3;

                                if (mysqli_stmt_num_rows($stmt) === NULL ) {
                                    echo "<h1 class='text-center'>No posts available.</h1>";
                                }
                            }

                        }
                    
                        while (mysqli_stmt_fetch($stmt)) :
                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="/project/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="#"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="/project/cms/images/<?php echo $post_image ?>" alt=""> <!-- it get data (img link) from db, it has been entered manually by me -->
                <hr>
                <p><?php echo $post_content ?>.</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>



              <?php  endwhile; mysqli_stmt_close($stmt); } else {

                redirect("/project/cms/index");



              } ?>
               
            

            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>

        </div>
        <!-- /.row -->
</div>
        <hr>

   <?php include("includes/footer.php"); ?>