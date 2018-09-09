<?php 

	if (isset($_GET['p_id'])) {
		$the_post_id = $_GET['p_id'];

		$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    	$select_posts_by_id = mysqli_query($connection, $query);

    	while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
	        $post_id = $row['post_id'];
	        $post_user = $row['post_user'];
	        $post_title = $row['post_title'];
	        $post_category_id = $row['post_category_id'];
	        $post_status = $row['post_status'];
	        $post_image = $row['post_image'];
	        $post_content = $row['post_content'];
	        $post_tags = $row['post_tags'];
	        $post_comment_count = $row['post_comment_count'];
	        $post_date = $row['post_date'];
	    }
	}


	if (isset($_POST['update_post'])) {

	    $post_title = $_POST['title'];
		$post_user = $_POST['post_user'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];
		$post_content = mysqli_real_escape_string($connection, $post_content);

		move_uploaded_file($post_image_temp, "../img/$post_image");

		if (empty($post_image)) {
			$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
			$select_image = mysqli_query($connection, $query);

			while ($row = mysqli_fetch_assoc($select_image)) {
				$post_image = $row['post_image'];
			}
		}



		$query = "UPDATE posts SET ";
		$query .= "post_title = '{$post_title}', ";
		$query .= "post_user = '{$post_user}', ";
		$query .= "post_category_id = '{$post_category_id}', ";
		$query .= "post_date = now(), ";
		$query .= "post_status = '{$post_status}', ";
		$query .= "post_tags = '{$post_tags}', ";
		$query .= "post_content = '{$post_content}', ";
		$query .= "post_image = '{$post_image}' ";
		$query .= "WHERE post_id = '{$the_post_id}' ";

		$update_post = mysqli_query($connection, $query);

		confirmQuery($update_post);

		//header("Location: posts.php");

?>


	<div class="row">
		<div class="col-md-8 col-md-offset-2 bg-success text-center" style="padding: 10px; font-style: bold; font-size: 20px;">
			<?php echo "Post Updated Successfully" . "</br>" . "<a href='../post.php?p_id={$the_post_id} '>View Udpated Post</a> Or <a href='posts.php'>Edit More Post</a>"; ?>
		</div>
	</div>

<?php }  ?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input value="<?php echo $post_title; ?>" type="text" name="title" class="form-control">
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

			<?php echo "<option value='$post_user'>{$post_user}</option>"; ?>
			
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


	<div class="form-group">
		<label for="post_status">Post Status</label>
		<select name="post_status" id="" class="form-control">
			<option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>

			<?php 
				if ($post_status == "Published") {
					echo "<option value='Draft'>Draft</option>";
				}else{
					echo "<option value='Published'>Publish</option>";
				}






			 ?>
		</select>
	</div>











	<!-- <div class="form-group">
		<label for="post_status">Post Status</label>
		<input value="<?php echo $post_status; ?>" type="text" name="post_status" class="form-control">
	</div> -->

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image"><img width="100px" src="../img/<?php echo $post_image ; ?>">
	</div>



	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php echo $post_tags; ?>" type="text" name="post_tags" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>

	</div>

	

	<div class="form-group">
      <input class="btn btn-primary" type="submit" name="update_post" value="Update & Publish Post">
    </div>
	

</form>