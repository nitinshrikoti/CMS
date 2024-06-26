<?php  include "includes/header.php"; ?>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']);

    $error = [
        'username'=> '',
        'email'=> '',
        'password'=> '',
    ];

    if(strlen($username) < 4) {
        $error['username'] = 'Username should be longer than 4 works';
    }
    if($username == '') {
        $error['username'] = 'Username cannot be empty';
    }
    if(username_exits($username)) {
        $error['username'] = 'Username already exits' ;
    }
    if($email == '') {
        $error['email'] = 'Email cannot be empty';
    }
    if(email_exits($email)) {
        $error['email'] = 'Email already exits, <a href="index.php">Please Login</a>' ;
    }
    if($password == '') {
        $error['password'] = 'Password cannot be empty';
    }

    foreach($error as $key => $value) {
        if(empty($value)) {
            unset($error[$key]);
        }
    }
    if(empty($error)) {
        register_user($username, $email, $password);
        login_user($username, $password);

    }
} 
?>

    <!-- Navigation -->    
    <?php  include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">
    
        <section id="login" >
            <div class="container row" style="padding: 60px 0; ">
                <!-- <div class="row"> -->
                    <div class="col-xs-4 col-xs-offset-4 ">
                        <div class="form-wrap panel panel-default bgcolor" style="padding: 20px 30px 40px 30px;">
                        <h1 style="text-align: center; margin-bottom: 24px;">Register</h1>
                            <form role="form" action="registration.php" method="post" id="registration-form" autocomplete="off">
                                
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on"
                                    value="<?php echo isset($username) ? $username : '' ?>" >
                                    <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on"
                                    value="<?php echo isset($email) ? $email : '' ?>" >
                                    <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                </div>
                        
                                <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                <!-- </div> /.row -->
            </div> <!-- /.container -->
        </section>

        <hr>
    </div>

<?php include "includes/footer.php";?>
