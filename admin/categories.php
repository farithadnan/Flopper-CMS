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
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        <div class="col-xs-6">
                        <?php include("includes/delete_modal.php"); ?>
                         <?php insert_categories(); ?>

                            <form method="post" action="categories.php">
                                <div class="form-group">
                                    <label for="cat-title" class="for"> Add post Category</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-plus"></i> Add category</button>

                                </div>
                            </form>

                            <?php  editCategories(); ?>


                        </div>

                        <div class="col-xs-6">

                            <table class="table table-bordered table-hover table-sm table-responsive" style="overflow: auto; ">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    

<?php findAllCategories(); ?>

<?php deleteCategories(); ?>
                                   

                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>






        <!-- /#page-wrapper -->
<script>

    $(document).ready(function(){

        $(".delete_link").on('click', function(){

            var id = $(this).attr("rel");
            var delete_url = "categories.php?delete=" + id + " ";


            $(".modal_delete_link").attr("href", delete_url); 

            $("#delModal").modal("show")
        });
    });

</script>

<?php include("includes/admin_footer.php"); ?>
