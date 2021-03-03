<?php 
function users_online(){

	if(isset($_GET['onlineusers']))
	{

		global $connection;

		if(!$connection)
		{
			session_start();

			include("../includes/db.php");

			$session = session_id();
		    $time = time();
		    $time_out_in_second = 5;
		    $time_out = $time - $time_out_in_second;

		    $query = "SELECT * FROM user_online WHERE session = '$session'";
		    $send_query = mysqli_query($connection, $query);
		    $count = mysqli_num_rows($send_query);

			    if($count == NULL)
			    {
			        mysqli_query($connection, "INSERT INTO user_online(session, time_log) VALUES('$session','$time') ");
			    }
			    else 
			    {

			        mysqli_query($connection, "UPDATE user_online SET time_log = '$time' WHERE session = '$session' ");
			    }

		    $user_online_query = mysqli_query($connection, "SELECT * FROM user_online WHERE time_log > '$time_out'");
		    echo $count_user = mysqli_num_rows($user_online_query);	

			}

	} //get request isset
}
users_online();

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
	    echo "<td>
	          <div class='dropdown'>
	          <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action
	          <span class='caret'></span></button>
	          <ul class='dropdown-menu'>
	            <li><a href='categories.php?edit={$cat_id}'><i class='fa fa-pencil'></i> Edit</a></li>
	            <li class='divider'></li>
	            <li><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='categories.php?delete={$cat_id}'><i class='fa fa-trash'></i> Delete</a></li>
	          </ul>
	          </div> 
	   	    </td>";
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