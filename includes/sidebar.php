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
        <h4><span class="glyphicon glyphicon-search"></span> Blog Search</h4>
        <form action="/project/cms/search" method="post"> 
        <div class="input-group">
            <input name="search" type="text" class="form-control" placeholder="Search this site">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit" title="click to search">
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
            <h4><span class="glyphicon glyphicon-time"></span> Logged in as: <?php echo ucfirst($_SESSION['username']); ?></h4>
            <a href="/project/cms/includes/logout.php" class="btn btn-danger" title="Click to log out"><span class="glyphicon glyphicon-log-out"></span> Logout</a>

        <?php else: ?>
            <h4><span class="glyphicon glyphicon-log-in"></span> Login</h4>
                <form  method="post"> 
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit" title="Click to log in">
                            <span class="glyphicon glyphicon-log-in"></span>
                            Login
                        </button>
                    </span>
                </div><br>
                    <div class="form-group">
                        <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot your Password?</a>
                    </div>
                </form> <!-- search form end -->

        <?php endif; ?>

    <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
    <?php  
        $query = "SELECT posts.post_category_id, posts.post_status, ";
        $query .= "categories.cat_id, categories.cat_title ";
        $query .= " FROM posts ";
        $query .= " LEFT JOIN categories ON posts.post_category_id =  categories.cat_id ";
                                                                     
        $select_all_categories_sidebar = mysqli_query($connection, $query);

        
     ?>
        <h4> <span class="glyphicon glyphicon-filter"></span> Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                <?php 
                    while ($row = mysqli_fetch_assoc($select_all_categories_sidebar)) { //amek and tukarkan column kepada key, and anak2 column as value dia s
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        $post_status = $row['post_status'];
                        
                        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'Admin')
                        {
                            if($post_status == 'Published')
                            {
                               echo "<li><a href='/project/cms/category/$cat_id'>{$cat_title}</a></li>"; 
                               
                            }
                            else {

                                 $message = "<br><div class='alert alert-danger'>";
                                 $message .=  "No categories available. Contact Admin for details.";
                                 $message .= "</div>";
                            }
                        }
                        else
                        {
                            $message = '';
                            echo "<li><a href='/project/cms/category/$cat_id'>{$cat_title}</a></li>";
                        }
                    }

                         echo $message;
                    

                ?>
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
<?php include "widget.php"; ?>

</div>