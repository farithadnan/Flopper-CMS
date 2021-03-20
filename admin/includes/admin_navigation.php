   
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/project/cms/admin/index">CMS <?php echo currentRole();?></a>
        </div>

        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href=""><i class="fa fa-fw fa-toggle-on "></i> Users Online:<span class="usersonline"></span></a></li>
            <li><a href="../index"><i class="fa fa-fw fa-home"></i> Home Site</a></li>

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

            $index_class = '';
            $dashboard_class = '';
            $post_class = '';
            $add_post_class = '';
            $category_class = '';
            $comment_class = '';
            $user_class = '';
            $add_user_class = '';
            $profile_class = '';

            $index = 'index.php';
            $dashboard = 'dashboard.php';
            $post = 'posts.php';
            $categories = 'categories.php';
            $comment = 'comments.php';
            $user = 'users.php';
            $profile = 'profile.php';

            if ($pageName == $index)
            {
                $index_class = 'active';
            }
            elseif ($pageName == $dashboard)
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
                <li class="<?php echo $index_class; ?>">
                    <a href="/project/cms/admin/index"><i class="fa fa-fw fa-dashboard"></i>My Data</a>
                </li>
                <?php if(is_admin()): ?>
                <li class="<?php echo $dashboard_class; ?>">
                    <a href="/project/cms/admin/dashboard"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a>
                </li>
               <?php endif; ?>
                <li class="<?php echo $post_class; ?>">
                    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-bookmark"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="posts_dropdown" class="collapse">
                        <li>
                            <a href="/project/cms/admin/posts"><i class="fa fa-fw fa-circle-o"></i> View All Posts</a>
                        </li>
                        <li>
                            <a href="posts.php?source=add_post"><i class="fa fa-fw fa-circle-o"></i> Add Posts</a>
                        </li>
                    </ul>
                </li>
                <li class="<?php echo $category_class; ?>">
                    <a href="/project/cms/admin/categories"><i class="fa fa-fw fa-th-list"></i>Categories</a>
                </li>

                <li class="<?php echo $comment_class; ?>">
                    <a href="/project/cms/admin/comments"><i class="fa fa-fw fa-comments-o"></i> Comments</a>
                </li>
 <?php if (is_admin($_SESSION['username'])) : ?>
                 <li class="<?php echo $user_class; ?>">
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="/project/cms/admin/users"><i class="fa fa-fw fa-circle-o"></i> View All Users</a>
                        </li>
                        <li>
                            <a href="users.php?source=add_user"> <i class="fa fa-fw fa-circle-o"></i> Add User</a>
                        </li>
                    </ul>
                </li>
<?php else: ?>
<?php endIf; ?>
                <li class="<?php echo $profile_class; ?>">
                    <a href="/project/cms/admin/profile"><i class="fa fa-fw fa-user"></i>Profile</a>
                </li>

            </ul>
        </div>

        <!-- /.navbar-collapse -->
    </nav>

