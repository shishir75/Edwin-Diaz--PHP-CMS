<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 

    if (isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($password)) {
            
            $firstname = mysqli_real_escape_string($connection, $firstname);
            $lastname = mysqli_real_escape_string($connection, $lastname);
            $username = mysqli_real_escape_string($connection, $username);
            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);

            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

            // $query = "SELECT randSalt FROM users";
            // $select_randsalt_query = mysqli_query($connection, $query);

            // if (!$select_randsalt_query) {
            //     die("Query Failed" . mysqli_error($connection));
            // }

            // $row = mysqli_fetch_array($select_randsalt_query);
            // $salt = $row['randSalt'];
            // $password = crypt($password, $salt);

            $query = "INSERT INTO users (user_firstname, user_lastname,username, user_email, user_password, user_role) ";
            $query .= "VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}' , '{$password}' , 'Subscriber' ) ";

            $register_user_query = mysqli_query($connection, $query);
            if (!$register_user_query) {
                die("Query Failed" . mysqli_error($connection));
            }

            $message = "Your Registration has been successful";

        }else{

            $message = "Fields cannot be emplty";
        }





    }else{
        $message = "Welcome to Register";
    }


?>



    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                        <div class="form-group bg-danger text-center" style="padding: 10px;"><h4><?php echo $message; ?></h4></div>

                        <div class="form-group">
                            <label for="username" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label for="username" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name">
                        </div>

                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
