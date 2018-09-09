<?php 

    if (isset($_POST['checkBoxArray'])) {
        foreach ($_POST['checkBoxArray'] as $key => $postValueId ) {

           $bulk_options = $_POST['bulk_options'];

           switch ($bulk_options) {
               case 'Published':
                   $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                   $update_to_published_status = mysqli_query($connection, $query);
                   confirmQuery($update_to_published_status);
                   break;

                case 'Draft':
                   $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                   $update_to_draft_status = mysqli_query($connection, $query);
                   confirmQuery($update_to_draft_status);
                   break;

                case 'delete':
                   $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                   $delete_post = mysqli_query($connection, $query);
                   confirmQuery($delete_post);
                   break;

                case 'clone':
                   $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                   $select_post_query = mysqli_query($connection, $query);
                   
                   while ($row = mysqli_fetch_assoc($select_post_query)) {
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_date = $row['post_date'];
                        $post_author = $row['post_author'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_content = $row['post_content'];
                        $post_content = mysqli_real_escape_string($connection, $post_content);
                    }

                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) "; // space is a must

                    $query .="VALUES({$post_category_id}, '{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}') "; // $ sign and '{}' are must

                    $clone_post_query = mysqli_query($connection, $query);
                    confirmQuery($clone_post_query);
                   break;
               
               default:
                   # code...
                   break;
           }
           
        }
    }
 ?>


<form action="" method="post"> 

    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4 form-group" style="margin-left: -15px">
            <select class="form-control" name="bulk_options" id="">
                <option value="">--- Select Option ---</option>
                <option value="Published">Publish</option>
                <option value="Draft">Draft</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
        </div>


        <thead>
            <tr>
                <td><input type="checkbox" id="selectAllBoxes" name=""></td>
                <th>Id</th>
                <th>Users</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>View Post</th>
                <th>Edit</th> 
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM posts ORDER BY post_id DESC";
                $select_posts = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_views_count = $row['post_views_count'];
                    
                    echo "<tr>";
                    ?>

                    <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value="<?php echo $post_id; ?>"></td>

                    <?php 
                        echo "<td>{$post_id}</td>";

                        if (!empty($post_author)) {
                           echo "<td>{$post_author}</td>";

                        } elseif (!empty($post_user)) {
                            echo "<td>{$post_user}</td>";
                        }

                        




                        echo "<td>{$post_title}</td>";

                        $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                        $select_catagories_id = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($select_catagories_id)) {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                        }

                        echo "<td>{$cat_title}</td>";

                        echo "<td>{$post_status}</td>";
                        echo "<td><img width = '100px' src='../img/$post_image' alt = 'image'></td>";
                        echo "<td>{$post_tags}</td>";

                        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                        $send_comment_query = mysqli_query($connection, $query);

                        $row = mysqli_fetch_array($send_comment_query);
                        $comment_id = $row['comment_id'];
                        $count_comment = mysqli_num_rows($send_comment_query);

                        echo "<td><a href='post_comments.php?id={$post_id}'>{$count_comment}</a></td>";

                        echo "<td>{$post_date}</td>";
                        echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
                        echo "<td><a name='view_post' href='../post.php?p_id={$post_id}'>View Post</a></td>";
                        echo "<td><a name='edit_post' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                        echo "<td><a onClick=\" javascript: return confirm('Are uou sure to delete?');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "</tr>";
                
                }
            ?>


            <?php 
                if (isset($_GET['delete'])) {
                    $the_post_id = $_GET['delete'];

                    $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
                    $delete_query = mysqli_query($connection, $query);
                    confirmQuery($delete_query);
                    header("Location: posts.php");
                }


                if (isset($_GET['reset'])) {
                    $the_post_id = $_GET['reset'];

                    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$the_post_id}";
                    $reset_views_query = mysqli_query($connection, $query);
                    confirmQuery($reset_views_query);
                    header("Location: posts.php");
                }







             ?>

            
        </tbody>
    </table>
</form>