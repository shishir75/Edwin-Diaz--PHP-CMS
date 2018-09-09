<?php 
    include 'includes/db.php';
    include 'includes/header.php';
    
 ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>


                <?php

                $per_page = 2; 


                if (isset($_GET['page'])) {
                    $page = isset($_GET['page']);
                } else {
                    $page = "";
                }

                if ($page == "" || $page == 1) {
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }




                $post_query_count = "SELECT * FROM posts ";
                $find_count = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count);

                $count = ceil($count / $per_page);



                $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
                $select_all_posts_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'],0,500);
                    $post_status = $row['post_status'];
                    $post_views_count = $row['post_views_count'];

                    if ($post_status == 'Published') {
                        
                    ?>


                    
                    <!-- First Blog Post -->

                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?>
                        <span class="glyphicon glyphicon-eye-open" style="float: right;"> Total Views: <?php echo "$post_views_count"; ?></span>
                    </p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id;?>"><img class="img-responsive" src="img/<?php echo $post_image; ?>" alt="<?php echo $post_image; ?>"></a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>


                <?php  } } ?>


                
            </div>

            <!-- Blog Sidebar Widgets Column -->

           <?php include 'includes/sidebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>


        <ul class="pager" style="font-size: 16px; font-weight: bold;">
            <?php 

                for ($i=1; $i <= $count ; $i++) { 

                    if ($i == $page) {
                        echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                    } else{
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }
                    
                }



             ?>
        </ul>



<?php include 'includes/footer.php'; ?>