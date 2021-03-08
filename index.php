
<?php include("includes/header.php"); ?>

    <!-- Navigation -->
<?php include("includes/nav.php"); ?>

    <!-- Page Content --> 
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">



                <?php 
                //variable to determine on how many page those user want in the post page
                $per_page = 5;

                // catching the get request
                if(isset($_GET['page']))
                {

                   $page =  $_GET['page'];
                } else
                {
                    $page = "";
                }

                //setting up page, if the  get request is null/1 it will preview the first data of 5
                if($page == "" || $page == 1)
                {
                    $page_1 = 0; //this is for the first page
                } else {
                    //if the the get request is more than 1 it will preview next 5 data from the previous one
                    $page_1 = ($page * $per_page) - $per_page; 
                    //if page 2, then it will multiply by 5 which becoming 10, then it will be substracted to 5 will equal to 5, then this 5 is the actual number of post will be display at the page 2 
                }

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin' ) {
                    $post_query_count = "SELECT * FROM posts";
                }
                else {

                    $post_query_count = "SELECT * FROM posts  WHERE post_status = 'Published'";

                }               
            
                $find_count = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count);
                if ($count < 1) {
                   echo "<h1 class='text-center'>No posts available</h1>";
                }
                else {

                 $count = ceil($count / $per_page);//round off the number if its float, this will determine how many pagination we will get in the post if one page is max with 5 post


                $query = "{$post_query_count}  LIMIT $page_1, $per_page"; 
                // Limit (first data), (how many data)
                $select_all_posts_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content =  substr($row['post_content'],0,100);
                    $post_status = $row['post_status'];


                    ?>



                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_user ?>&p_id=<?php echo $post_id ?>"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted <?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""> <!-- it get data (img link) from db, it has been entered manually by me -->
                </a>
                <hr>
                <p><?php echo $post_content ?>.</p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?> ">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>



              <?php  }} ?>
               
            

            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>

        </div>
        <!-- /.row -->
</div>
        <hr>

        <ul class="pager">
        <?php 

            for ($i=1; $i <= $count; $i++) { 
                if($i == $page)
                {
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                } 
                else {

                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
                
            }
         ?>
        </ul>

   <?php include("includes/footer.php"); ?>