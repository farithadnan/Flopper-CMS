<?php 

    if(ifItIsMethod('post')){
        if(isset($_POST['login']))
        {
            if(isset($_POST['username']) && isset($_POST['password']))
            {
                login_user($_POST['username'], $_POST['password']);

            } else{

                redirect('index');
            } 
        }

    }
?>
<div class="col-md-4">

    <!-- Blog Search Well -->
    <!-- gotta create using form to enter data and send to db, where the data will be filtered afterwar(search) -->

    <!-- executing script at search.php -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="/project/cms/search" method="post"> 
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
        </form> <!-- search form end -->
        <!-- /.input-group -->
    </div>

                                                                                                                                                      
    <!-- Login  -->
    <div class="well">
        <?php if (isset($_SESSION['user_role'])) : ?>
            <h4>Logged in as: <?php echo $_SESSION['username']; ?></h4>
            <a href="/project/cms/includes/logout.php" class="btn btn-danger">Logout</a>

        <?php else: ?>
            <h4>Login</h4>
                <form  method="post"> 
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">
                            Submit
                        </button>
                    </span>
                </div>
                    <div class="form-group">
                        <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                    </div>
                </form> <!-- search form end -->

        <?php endif; ?>

    <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
    <?php  
        $query = "SELECT * FROM categories "; //select all from table categories                                                                                 
        $select_all_categories_sidebar = mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db                
     ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                <?php 
                    while ($row = mysqli_fetch_assoc($select_all_categories_sidebar)) { //amek and tukarkan column kepada key, and anak2 column as value dia s
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];


                        if($_SESSION['user_role'] != 'Admin')
                        {
                            $post_query = "SELECT * FROM posts WHERE post_category_id = {$cat_id}";
                            $select_id = mysqli_query($connection, $post_query);
                       

                            while($row2 = mysqli_fetch_assoc($select_id))
                            {
                                $post_category_id = $row2['post_category_id'];
                                $post_status = $row2['post_status'];

                                if($cat_id == $post_category_id && $post_status =='Published')
                                {
                                    echo "<li><a href='/project/cms/category/$cat_id'>{$cat_title}</a></li>";
                                }
                            }

                        }
                        else
                        {
                            echo "<li><a href='/project/cms/category/$cat_id'>{$cat_title}</a></li>";
                        }
                    }


                ?>
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
<?php include "widget.php"; ?>

</div>