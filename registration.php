<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
<?php     if(isset($_POST['submit']))
{
    $username =    trim($_POST['username']);
    $email =       trim($_POST['email']);
    $password =    trim($_POST['password']);
    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];
    if(strlen($username)<4)
    {
        $error['username'] = "<h6 style='color:red;'>Username needs to be longer<h6>";
    }
    if($username=='')
    {
        $error['username'] = "<h6 style='color:red; '>Username cannot be empty</h6>";
    }
    if(username_exists($username))
    {
        $error['username'] = "<h6 style='color:red;'>Username already exists </h6><a href='index.php'>Log in Here</a> ";
    }
    if($email=='')
    {
        $error['email'] = "<h6 style='color:red;'>Email cannot be empty</h6>";
    }
    if(email_exists($email))
    {
        $error['email'] = "<h6 style='color:red;'>Email already exists</h6>";
    }
    if($password=='')
    {
        $error['password'] = "<h6 style='color:red;'>Password cannot be empty</h6>";
    }
    foreach($error as $key =>$value)
    {
        if(empty($value))
        {
            unset($error[$key]);
        }
        if(empty($error))
        {
            register_user($username, $email, $password);
        }
    }

}
?>

    <!-- Navigation -->
    
    <?php  include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>" placeholder="Enter Desired Username">
                            <p><?php echo isset($error['username']) ? $error['username']: '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>" >
                            <p><?php echo isset($error['email']) ? $error['email']: '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo isset($error['password']) ? $error['password']: '' ?></p>
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
