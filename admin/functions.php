<?php 

function confirmQuery($result) {

	global $connection;

	if (!$result) {
		die('QUERY FAILED ' . mysqli_error($connection));
	}

}

function insert_categories() {

	global $connection;

    if(isset($_POST['submit']))
    {

    $cat_title = $_POST['cat_title'];

	    if($cat_title =="" || empty($cat_title))
	    {
	        echo "This field should not be empty";

	    } else
	    	{
	        $query = "INSERT INTO categories(cat_title)";
	        $query .="VALUE('{$cat_title}')";
	        $create_category = mysqli_query($connection, $query);

	        if(!$create_category)
	      	  {
	            die('QUERY FAILED ') . mysqli_error($connection);
	          }	
	    	}
	}

}


function findAllCategories() {

	global $connection;

	//find all categories query

	 $query = "SELECT * FROM categories "; //select all from table categories 
	            $select_categories = mysqli_query($connection, $query); //mysqli_query() use to simplify the use of performing query to db

	while ($row = mysqli_fetch_assoc($select_categories)) 
	{ //amek and tukarkan column kepada key, and anak2 column as value dia s
		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title'];

		echo"<tr>";
		echo " <td>{$cat_id}</td>";
		echo " <td>{$cat_title}</td>";
		echo "<td><a href='categories.php?delete={$cat_id}' class='btn btn-danger'><i class='fa fa-trash'></i> Delete</a></td>";
		echo "<td><a href='categories.php?edit={$cat_id}' class='btn btn-info'><i class='fa fa-edit'></i> Update</a></td>";
		echo "</tr>";
	}

}



function editCategories() {
	global $connection;
	
    if (isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];
        include "includes/update_categories.php";
    }

}



function deleteCategories() {

	global $connection;

	//delete query
	//this one will store cat id, from the link after delete=
	if(isset($_GET['delete']))
	{
	    $the_cat_id = $_GET['delete']; 
	    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
	    $delete_query = mysqli_query($connection, $query);
	    header("Location: categories.php");
	}
}





 ?>