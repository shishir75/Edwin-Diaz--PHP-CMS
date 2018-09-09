<?php


if (isset($_GET['edit_user'])) {
	$the_user_id = $_GET['edit_user'];

	$query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }

?>

<?php  





	if (isset($_POST['edit_user'])) {
		
	    $user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_role = $_POST['user_role'];

		// $post_image = $_FILES['image']['name'];
		// $post_image_temp = $_FILES['image']['tmp_name'];

		$username = $_POST['username'];
		$user_email = $_POST['user_email'];
		$user_password = $_POST['user_password'];
		//$post_date = date('d-m-y');

		//move_uploaded_file($post_image_temp, "../img/$post_image");
		
		
		

		

		if (!empty($user_password)) {
			$query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
			$get_user_query = mysqli_query($connection, $query_password);
			confirmQuery($get_user_query);

			$row = mysqli_fetch_array($get_user_query);

			$db_user_password = $row['user_password'];

			if ($db_user_password != $user_password) {
				$hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
			}

			$query = "UPDATE users SET ";
			$query .= "user_firstname = '{$user_firstname}', ";
			$query .= "user_lastname = '{$user_lastname}', ";
			$query .= "user_role = '{$user_role}', ";
			$query .= "username = '{$username}', ";
			$query .= "user_email = '{$user_email}', ";
			$query .= "user_password = '{$hashed_password}' ";
			$query .= "WHERE user_id = '{$the_user_id}' ";

			$edit_user_query = mysqli_query($connection, $query);

			confirmQuery($edit_user_query);

			echo "User Updated" . "<a href='users.php'>View Users</a>";




		}

		

		//header("Location: users.php");

	}
} else {
	header("Location: index.php");
}


 ?>



<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Firstname</label>
		<input type="text" value="<?php echo $user_firstname; ?>" name="user_firstname" class="form-control">
	</div>

	<div class="form-group">
		<label for="title">Lastname</label>
		<input type="text" value="<?php echo $user_lastname; ?>" name="user_lastname" class="form-control">
	</div>


	<div class="form-group">
		<label for="User_Role">User Role</label>
		<select name="user_role" id="" class="form-control">

			<option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
			<?php 
				if ($user_role == 'Admin') {
					echo "<option value='Subscriber'>Subscriber</option>";
				}else{
					echo "<option value='Admin'>Admin</option>";
				}


			 ?>

		</select>
	</div>

	<div class="form-group">
		<label for="title">Username</label>
		<input type="text" value="<?php echo $username; ?>" name="username" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_author">Email</label>
		<input type="email" value="<?php echo $user_email; ?>" name="user_email" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_status">Password</label>
		<input type="password" value="<?php echo $user_password; ?>" name="user_password" class="form-control">
	</div>

	<!-- <div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image">
	</div> -->


	<!-- <div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" name="post_tags" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
	</div> -->

	

	<div class="form-group">
      <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
    </div>
	

</form>