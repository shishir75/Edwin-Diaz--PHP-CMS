<?php 

if (isset($_POST['create_user'])) {
	
    $user_firstname = $_POST['user_firstname'];
	$user_lastname = $_POST['user_lastname'];
	$user_role = $_POST['user_role'];

	// $post_image = $_FILES['image']['name'];
	// $post_image_temp = $_FILES['image']['tmp_name'];

	$username = $_POST['username'];
	$user_email = $_POST['user_email'];
	$user_password = $_POST['user_password'];
	//$post_date = date('d-m-y');
	
	$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

	//move_uploaded_file($post_image_temp, "../img/$post_image");

	$query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) "; // space is a must

	$query .="VALUES('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$user_password}') "; // $ sign and '{}' are must

	$create_user_query = mysqli_query($connection, $query);

	confirmQuery($create_user_query);


?>


	<div class="row">
		<div class="col-md-8 col-md-offset-2 bg-success text-center" style="padding: 10px; font-style: bold; font-size: 20px;">
			<?php echo "User Created Sussefully" . "</br>" . "<a href='users.php'>View All Users</a>"; ?>
		</div>
	</div>

<?php }  ?>





<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Firstname</label>
		<input type="text" name="user_firstname" class="form-control">
	</div>

	<div class="form-group">
		<label for="title">Lastname</label>
		<input type="text" name="user_lastname" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_category">User Role</label>
		<select name="user_role" id="" class="form-control">

			<option value="Subscriber">---- Select Option ----</option>
			<option value="Admin">Admin</option>
			<option value="Subscriber">Subscriber</option>


		</select>
	</div>

	<div class="form-group">
		<label for="title">Username</label>
		<input type="text" name="username" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_author">Email</label>
		<input type="email" name="user_email" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_status">Password</label>
		<input type="password" name="user_password" class="form-control">
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
      <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
	

</form>