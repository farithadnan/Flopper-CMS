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
                            <?php 
                                if(isset($_POST['submit'])){

                                    $cat_title = $_POST['cat_title'];

                                    if($cat_title =="" || empty($cat_title)){

                                        echo "This field should not be empty";
                                    } else{
                                        $query = "INSERT INTO categories(cat_title)";
                                        $query .="VALUE('{$cat_title}')";
                                        $create_category = mysqli_query($connection, $query);

                                        if(!$create_category)
                                        {
                                            die('QUERY FAILED') . mysqli_error($connection);
                                        }
                                    }

                                }


                             ?>
                            <form method="post" action="categories.php">
                                <div class="form-group">
                                    <label for="cat-title" class="for"> Add Category</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-plus"></i> Add category</button>

                                </div>
                            </form>

                            <?php  
                                if (isset($_GET['edit'])) {
                                    $cat_id = $_GET['edit'];
                                    include "includes/update_categories.php";
                                }
                            ?>


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
                                    

<?php 
//find all categories query

 $query = "SELECT * FROM categories "; //select all from table categories 
            $select_categories = mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

while ($row = mysqli_fetch_assoc($select_categories)) { //amek and tukarkan column kepada key, and anak2 column as value dia s
$cat_id = $row['cat_id'];
$cat_title = $row['cat_title'];
echo"<tr>";
echo " <td>{$cat_id}</td>";
echo " <td>{$cat_title}</td>";
echo "<td><a href='categories.php?delete={$cat_id}' class='btn btn-danger'><i class='fa fa-trash'></i> Delete</a></td>";
echo "<td><a href='categories.php?edit={$cat_id}' class='btn btn-info'><i class='fa fa-edit'></i> Update</a></td>";
echo "</tr>";
}

?>

<?php 

//delete query
//this one will store cat id, from the link after delete=
if(isset($_GET['delete']))
{
    $the_cat_id = $_GET['delete']; 
    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: categories.php");
}


 ?>
                                   

                                   
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


<?php include("includes/admin_footer.php"); ?>
