<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
<?php
 


if(isset($_POST['submit']))
{
    $to ="abazienisa9@gmail.com";
    $subject =wordwrap($_POST['subject'],70);
    $body = $_POST['body'];
    $header="FROM:". $_POST['email']."";
    ini_set("SMTP","localhost");
   ini_set("smtp_port","25");
   ini_set("sendmail_from","abazienisa9@gmail.com");
   ini_set("sendmail_path", "C:\wamp\bin\sendmail.exe -t");
    mail($to,$subject,$body,$header);
       /* $query1 = "INSERT INTO users (username, user_password, user_email, user_role)  
        VALUES('{$username}','{$password}','{$email}','subscriber' )";
        $register = mysqli_query($connection, $query1);
        confirm($register);
        echo "<h4 style='color:green; text-align:center;'>You have been registrated successfully</h4>";
      */
    
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
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
     
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                        </div>
                         <div class="form-group">
                            <label for="text" class="sr-only">Message</label>
                            <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
