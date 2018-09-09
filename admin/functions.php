<?php 


function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, strip_tags($string));
}



function confirmQuery($result)
{
	global $connection;
	if (!$result) {
       die('Query Failed' . mysqli_error($connection));
    }
}



function insert_categories()
{
	global $connection;
	 if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
           echo "<h5 class= 'text-danger'>This field should not be empty</h5>";
     	}else{

            $query = "INSERT INTO categories(cat_title) VALUES('{$cat_title}')";
            $create_categrory_query = mysqli_query($connection, $query);

            if (!$create_categrory_query) {
               die('Query Failed' . mysqli_error($connection));
            }
     	}

    }
}   // insert_categories() function end


function findAllCategories()
{
	global $connection;
	$query = "SELECT * FROM categories";
    $select_catagories = mysqli_query($connection, $query);

     while ($row = mysqli_fetch_assoc($select_catagories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
                                        
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete=$cat_id'>Delete</td>";
        echo "<td><a href='categories.php?edit=$cat_id'>Update</td>";
        echo "</tr>";

     } 
}    // findAllCategories() function end



function deleteCategories()
{
	global $connection;
	if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id ={$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}  // deleteCategories() function end


function users_online()
{

    if (isset($_GET['onlineusers'])) {
        
        global $connection;

        if (!$connection) {
            session_start();

            include '../includes/db.php';

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session' ";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session,time) VALUES('$session', '$time') ");
            } else{
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session' ");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM  users_online WHERE time > '$time_out' ");

            $count_user = mysqli_num_rows($users_online_query);
            echo $count_user;

        }

    } // get request

}

users_online();

  // users_online() function end











 ?>