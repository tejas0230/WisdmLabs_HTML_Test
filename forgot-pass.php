<?php
/**
 * Get the required classes
 */
require('connection.php');
require('user.php');
require('send-mail.php');

/**
 * Create objects / get singleton instances
 */
$db_obj = DBConn::getDBConn();
$user = new User();
$mailSender = new MailSender();

$user_feedback="";

if($_SERVER["REQUEST_METHOD"]==="POST")
{
    //get data from form
    $user_mail = $_POST['user-mail'];
    
    $user_mail = $user->TrimAndSanitizeEmail($user_mail);
    if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL))
    {
        $feedback = "Invalid Email";
        return 1;
    }

    if($user->CheckUserExists($user_mail,$db_obj))
    {
        $token = $user->GenerateToken();
        $sql = "Update user set token = '$token' where user_email = '$user_mail'";
        $result = $db_obj->query($sql);
        if($result===TRUE)
        {
            if($mailSender->SendMailToUser($user_mail,$token))
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
$db_obj->close();
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