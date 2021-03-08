
<?php include("includes/header.php"); ?>

    <!-- Navigation -->
<?php include("includes/nav.php"); ?>

    <!-- Page Content --> 
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 
                   $category_id = mysqli_escape_string($connection, trim($_GET['category']));
                   $query_cat = "SELECT * FROM categories  WHERE cat_id = {$category_id}";
                   $choose_cat = mysqli_query($connection, $query_cat);

                   $row_cat = mysqli_fetch_assoc($choose_cat);
                   $current_cat = $row_cat['cat_title'];

                    if(isset($_GET['category'])){
                        $post_category_id = mysqli_escape_string($connection, trim($_GET['category'])); 
                    
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin' ) {
                        $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id";
                    }
                    else {

                        $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'Published' ";

                    }
                    
                    $select_all_posts_query = mysqli_query($connection, $query);

                    if (mysqli_num_rows( $select_all_posts_query) <1 ) {
                        echo "<h1 class='text-center'>No posts available for {$current_cat}</h1>";
                    }
                    else {

                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_category_id = $row['post_category_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content =  substr($row['post_content'],0,100);

                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="#"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""> <!-- it get data (img link) from db, it has been entered manually by me -->
                <hr>
                <p><?php echo $post_content ?>.</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>



              <?php  } } } else {

                header("Location: index.php");



              } ?>
               
            

            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>

        </div>
        <!-- /.row -->
</div>
        <hr>

   <?php include("includes/footer.php"); ?>