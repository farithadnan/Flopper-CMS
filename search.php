<?php include("includes/header.php"); ?>

    <!-- Navigation -->
<?php include("includes/nav.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">


                <?php 
                 // filter if the submit is click first before echoing the related data
                    if (isset($_POST['submit'])) {
                         $search = $_POST['search'];

                         $query = "SELECT * FROM posts where post_tag LIKE '%$search%' "; //digunakan utk bandingkan data yg user masukkn dlm input search kedalam db 

                         $search_query = mysqli_query($connection, $query); //then check query w connection

                         if(!$search_query) {
                            die("Query Failed" . mysqli_error($connection));
                         }



                         $count = mysqli_num_rows($search_query);//check hw many result comming out from this; by rows 

                         if($count == 0) {
                            echo "<h1>No Result</h1>";
                         } else{

                        while ($row = mysqli_fetch_assoc($search_query)) {
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];

                            ?>


                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""> <!-- it get data (img link) from db, it has been entered manually by me -->
                        <hr>
                        <p><?php echo $post_content ?>.</p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>



              <?php  } 
               
            
                         }
                     }

            ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include("includes/sidebar.php"); ?>

        </div>
        <!-- /.row -->
</div>
        <hr>

   <?php include("includes/footer.php"); ?>