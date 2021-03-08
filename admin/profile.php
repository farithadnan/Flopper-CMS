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
                            Welcome to <?php echo $_SESSION['user_role']; ?>
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
<?php 

    if(isset($_SESSION['username']))
    {
        $username = escape($_SESSION['username']);
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_user_profile_query = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_array($select_user_profile_query)) {
            $user_id = escape($row['user_id']);
            $Username = escape($row['username']);
            $user_password = escape($row['user_password']);
            $user_firstname = escape($row['user_firstname']);
            $user_lastname = escape($row['user_lastname']);
            $user_email = escape($row['user_email']);
            // $user_image = $row['user_image'];
        }
   

    if (isset($_POST['edit_user'])) {

        edit_profile($user_firstname = escape($_POST['user_firstname']),  $user_lastname = escape($_POST['user_lastname']),
        $username = escape($_POST['username']),  $user_email = escape($_POST['user_email']), $user_password = escape($_POST['user_password'])); 
    }

 } 
 ?>
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="user_firstname">First Name</label>
                                    <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname?>"  placeholder="Enter First Name">
                                </div>

                                <div class="form-group">
                                    <label for="user_lastname">Last Name</label>
                                    <input type="text" class="form-control" name="user_lastname" id="user_lastname" value="<?php echo $user_lastname?>"  placeholder="Enter Last Name">
                                </div>


                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $username?>" placeholder="Enter Username">
                                </div>

                                <div class="form-group">
                                    <label for="post_tags">Email</label>
                                    <input type="email" class="form-control" name="user_email" id="user_email" placeholder="example@gmail.com" value="<?php echo $user_email?>">
                                </div>

                                <div class="form-group">
                                    <label for="post_tags">Password</label>
                                    <input autocomplete="off" type="password" class="form-control" name="user_password" id="user_password" placeholder="Enter New Password">
                                </div>


                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                                </div>

                            </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>

        <!-- /#page-wrapper -->
<?php include("includes/admin_footer.php"); ?>
