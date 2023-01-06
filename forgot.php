<?php  use PHPMailer\PHPMailer\PHPMailer; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/nav.php"; ?>

<?php 

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require "classes/Config.php";
//Create an instance; passing `true` enables exceptions
?>

<?php 
if(!ifItIsMethod('get') || !isset($_GET['forgot']))
{
    header("Location: login.php");
}
if(ifItIsMethod('post') )
{
  if(isset($_POST['email']))
  {
        $email = escape($_POST['email']);
        $length=40;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        if(email_exists($email))
        {
          
            if ($stmt=mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email=?"))
            {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $mail = new PHPMailer(true);

                try 
                {
              
                    //Server settings
                  /*  $mail->SMTPOptions = array(
                        'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                        )
                        );*/
                        $message = '';
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
                    $mail->isSMTP();                                          
                    $mail->Host       = 'send.smtp.mailtrap.io';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = "api";                    
                    $mail->Password   ='d9bcd6e10a2d0dccda1f8fb4f6e15fdc';                        
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
                    $mail->Port       =  587 ;
                    $mail->CharSet    = 'UTF-8';                               
                    //Recipients
                    $mail->setFrom('abazienisa9@gmail.com', 'enisa');
                    $mail->addAddress($email);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Here is the subject';
                    $mail->Body    = "This is the HTML message body <b>in bold!</b>
                    <p>Click here to reset the password
                    <a href='localhost/cms/reset.php?email='.$email.'&token='.$token.'</a></p>";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    if ($mail->send()) {
                        $message = "<h3 style='color:green;'>Check your email!</h3>";
                    }
                  
                }
                catch (Exception $e)
                {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                                    
            }
            else
            {
                mysqli_error($connection);
            }
        }

    }
 }
?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>
                                            <p><?php if (ifItIsMethod('post')) {
                                                echo $message;
                                            }?></p>
                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

