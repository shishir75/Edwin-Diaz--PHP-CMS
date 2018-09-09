<?php 

if (isset($_POST['create_post'])) {

	$post_title = escape($_POST['title']);
	$post_user = $_POST['post_user'];
	$post_category_id = $_POST['post_category'];
	$post_status = $_POST['post_status'];

	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];

	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_content = mysqli_real_escape_string($connection, $post_content);
	$post_date = date('d-m-y');

	move_uploaded_file($post_image_temp, "../img/$post_image");

	$query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) "; // space is a must

	$query .="VALUES({$post_category_id}, '{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}') "; // $ sign and '{}' are must

	$create_post_query = mysqli_query($connection, $query);

	confirmQuery($create_post_query);

	$the_post_id = mysqli_insert_id($connection); // to see the last id


?>


	<div class="row">
		<div class="col-md-8 col-md-offset-2 bg-success text-center" style="padding: 10px; font-style: bold; font-size: 20px;">
			<?php echo "Post Added Successfully" . "</br>" . "<a href='../post.php?p_id={$the_post_id} '>View Added Post</a> Or <a href='posts.php'>View All Post</a>"; ?>
		</div>
	</div>

<?php }  ?>





<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" name="title" class="form-control">
	</div>


	<div class="form-group">
		<label for="post_category">Post Category</label>
		<select name="post_category" id="" class="form-control">
			<?php 

				$query = "SELECT * FROM categories";
				$select_catagories = mysqli_query($connection, $query);
				confirmQuery($select_catagories);

				while ($row = mysqli_fetch_assoc($select_catagories)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<option value='$cat_id'>{$cat_title}</option>";
				}  
			 ?>

		</select>
	</div>


	<div class="form-group">
		<label for="user">Users</label>
		<select name="post_user" id="" class="form-control">
			<?php 

				$query = "SELECT * FROM users";
				$select_users = mysqli_query($connection, $query);
				confirmQuery($select_users);

				while ($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];

                    echo "<option value='$username'>{$username}</option>";
				}  
			 ?>

		</select>
	</div>


	<!-- <div class="form-group">
		<label for="post_author">Post Author</label>
		<input type="text" name="author" class="form-control">
	</div> -->

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select name="post_status" id="" class="form-control">
			<option value="Draft">--- Select Post Status ---</option>
			<option value="Draft">Draft</option>
			<option value="Published">Publish</option>
		</select>





		<!-- <input type="text" name="post_status" class="form-control"> -->
	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image">
	</div>


	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" name="post_tags" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
	</div>

	

	<div class="form-group">
      <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
	

</form>