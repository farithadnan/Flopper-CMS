 <!-- Header -->
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
                            Admin Dashboard 
                            <small>
                                <?php echo ucfirst(currentUser()); ?>
                            </small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

       
                <!-- Body -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                    <div class='huge'><?php echo  $post_count =  recordCount('posts'); ?></div>
                                   
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo  $comment_counts =  recordCount('comments'); ?></div>
                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo  $user_counts =  recordCount('users'); ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                     <div class='huge'><?php echo  $category_counts =  recordCount('categories'); ?></div>                             
                                    <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <?php 
         
                    // ---------------------------------------------------------------------------------//
                    //  Checking post status, comment status and user status using checkStatus function //
                    // ---------------------------------------------------------------------------------//
                    
                    // Extracting published post
                    $post_published_count = checkStatus('posts', 'post_status', 'Published');

                    // Extracting Draft post
                    $post_draft_count = checkStatus('posts', 'post_status', 'Draft');

                    // Extracting Unapproved comment
                    $unapproved_comment_count = checkStatus('comments', 'comment_status', 'Unapproved');

                    // Extracting Subscriber Role
                    $subscriber_count = checkUserRole('users', 'user_role', 'Subscriber');

                 ?>

                <!--  Bar chart -->
                <div class="row">

                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data', 'Count'],

                          <?php 

                            $element_text = ['All Posts','Active Posts', 'Draft Posts','Categories', 'Users', 'Subsribers', 'Comments', 'Pending Comments'];
                            $element_count = [$post_count, $post_published_count, $post_draft_count, $category_counts, $user_counts,  $subscriber_count, $comment_counts, $unapproved_comment_count];

                            for($i = 0; $i < 8; $i++){
                                echo "['{$element_text[$i]}'" . " ," . "{$element_count[$i]}],";
                            }

                           ?>

                        ]);

                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>    

                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->


<?php include("includes/admin_footer.php"); ?>

<script>
    $(document).ready(function(){

        var pusher = new Pusher('8d2c9da29cac74485483', {
            cluster: 'ap1',
            encrypted: true
        });

        var notificationChannel = pusher.subscribe('notifications');
        notificationChannel.bind('new_user', function(notification){
        var message = notification.message;

        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": true,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": true,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

        toastr["info"](`${message} just registered`, `New User Registration`);
            
        });

    });
</script>