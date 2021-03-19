   
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/project/cms/admin/index">CMS <?php echo $_SESSION['user_role'];?></a>
        </div>

        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href="">Users Online:<span class="usersonline"></span></a></li>
            <li><a href="../index">Home Site</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 

        <?php 
            $user = currentUser();
            echo ucfirst($user);
        ?>
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/project/cms/admin/profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>


        <?php 

            $pageName = basename($_SERVER['PHP_SELF']);

            $dashboard_class = '';
            $post_class = '';
            $add_post_class = '';
            $category_class = '';
            $comment_class = '';
            $user_class = '';
            $add_user_class = '';
            $profile_class = '';

            

            $dashboard = 'index.php';
            $post = 'posts.php';
            $categories = 'categories.php';
            $comment = 'comments.php';
            $user = 'users.php';
            $profile = 'profile.php';

            if ($pageName == $dashboard)
            {
                $dashboard_class = 'active';
            }
            elseif ($pageName == $post)
            {
                $post_class = 'active';
            }

            elseif ($pageName == $categories)
            {
                $category_class = 'active';
            }
            elseif ($pageName == $comment)
            {
                $comment_class = 'active';
            }
            elseif ($pageName == $user)
            {
                $user_class = 'active';
            }
            elseif ($pageName == $profile)
            {
                $profile_class = 'active';
            }
         ?>


        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        
        <div class="collapse navbar-collapse navbar-ex1-collapse">

            <ul class="nav navbar-nav side-nav">
                <li class="<?php echo $dashboard_class; ?>">
                    <a href="/project/cms/admin/index"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li class="<?php echo $post_class; ?>">
                    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="posts_dropdown" class="collapse">
                        <li>
                            <a href="/project/cms/admin/posts">View All Posts</a>
                        </li>
                        <li>
                            <a href="posts.php?source=add_post">Add Posts</a>
                        </li>
                    </ul>
                </li>
<?php if (is_admin($_SESSION['username'])) : ?>
                <li class="<?php echo $category_class; ?>">
                    <a href="/project/cms/admin/categories"><i class="fa fa-fw fa-wrench"></i>Categories</a>
                </li>
<?php else: ?>
<?php endIf; ?>
                <li class="<?php echo $comment_class; ?>">
                    <a href="/project/cms/admin/comments"><i class="fa fa-fw fa-file"></i> Comments</a>
                </li>
 <?php if (is_admin($_SESSION['username'])) : ?>
                 <li class="<?php echo $user_class; ?>">
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="/project/cms/admin/users">View All Users</a>
                        </li>
                        <li>
                            <a href="users.php?source=add_user">Add User</a>
                        </li>
                    </ul>
                </li>
<?php else: ?>
<?php endIf; ?>
                <li class="<?php echo $profile_class; ?>">
                    <a href="/project/cms/admin/profile"><i class="fa fa-fw fa-dashboard"></i>Profile</a>
                </li>

            </ul>
        </div>

        <!-- /.navbar-collapse -->
    </nav>

