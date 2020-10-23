        
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <!-- gotta create using form to enter data and send to db, where the data will be filtered afterwar(search) -->


                <!-- executing script at search.php -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method="post"> 
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

                            echo "<li><a href='#'>{$cat_title}</a></li>";
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