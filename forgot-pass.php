<?php
include 'connection.php';

use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$user_feedback="";

function CheckUserExists($user_mail,$conn)
{
    $sql = "SELECT * from user where user_email = '{$user_mail}'";
    $result = $conn->query($sql);
    if($result->num_rows===1)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function GenerateToken()
{
    $n=24;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
 
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
 
    return $randomString;
}
if($_SERVER["REQUEST_METHOD"]==="POST")
{
    //get data from form
    $user_mail = $_POST['user-mail'];
    
   //sanitaize data - remove white spaces from starting and end
    $user_mail = trim($user_mail);
    //sanitaize data - remove dangerous characters to prevent HTML injection
    $user_mail = filter_var($user_mail,FILTER_SANITIZE_EMAIL);
    if(!filter_var($user_mail,FILTER_VALIDATE_EMAIL))
    {
        $feedback = "Invalid Email";
        return 1;
    }
    if(CheckUserExists($user_mail,$conn))
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username='tejas.bendkule@wisdmlabs.com';
        $mail->Password = 'cqnilrbjdzztuein';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('tejas.bendkule@wisdmlabs.com');
        $mail->addAddress($user_mail);
        $mail->isHTML(true);
        $token = GenerateToken();
        $mailBody = "Please follow the link to reset your password\n http://localhost/wisdm/WisdmLabs_HTML_Test/forgot.php?token={$token}";
        $mail->Subject = "Password reset link";
        $mail->Body = $mailBody;

        $sql = "Update user set token = '$token' where user_email = '$user_mail'";

        $result = $conn->query($sql);
        if($result===TRUE)
        {
            if($mail->send())
            {
            echo"<script>alert('Mail sent');document.location.href='sign-in.php';</script>";
            }
        }
    }
    else
    {
        $user_feedback = "User doesn't exist - sign up";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Pass</title>
    <link rel="stylesheet" href="CSS/style.css?v=<?php echo time();?>">
</head>
<body>
<section class="header">
        <div class="container">
            <div class="nav-bar">
                <a href="index.php" class="logo">Logo</a>
                <!-- <button class="sign-in">Sign In</button> -->
            </div>
        </div>
    </section>
    <section class="form">
        <div class="container">
            <div class="form-section">
            <form action="" method="POST" class="sign-up-form">
                <div class="form-title">Forgot Password</div>

                <div class="form-input-container">
                    <label for="user-mail" class="user-lable">Please enter your email</label>
                    <input type="email" name="user-mail" id="user-mail" class="user" placeholder="you@example.com">

                    <div class="user-error-message"><?=$user_feedback?></div>
                </div>

                <button type="submit" class="form-sign-in-button">Reset Password</button>
                     
            </form>
            </div>
        </div>
    </section>
</body>
</html>