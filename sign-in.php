<?php
session_start();
require('connection.php');

require('user.php');
$user = new User();

$db_obj = DBConn::getDBConn();

$user_feedback="";
$pass_feedback = "";

if($_SERVER["REQUEST_METHOD"]==="POST")
{
    //get data from form
    $user_mail = $_POST['user-mail'];
    $user_pass = $_POST['user-password'];

    $user_mail = $user->TrimAndSanitizeEmail($user_mail);

    if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL))
    {
        $feedback = "Invalid Email";
        return 1;
    }

    if($user->CheckUserExists($user_mail,$db_obj))
    {
        $pass = $user->GetUserPassword($user_mail,$db_obj);
        $user_pass = sha1($user_pass);
        if($pass===$user_pass)
        {
            $_SESSION['current_user'] = $user_mail;
            header("Location:index.php");

        }
        else
        {
            $pass_feedback = "Password Incorrect";
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
    <title>Sign In</title>
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
            <form action="" method="POST" class="sign-in-form">
                <div class="form-title">Sign In</div>

                <div class="form-input-container">
                    <label for="user-mail" class="user-lable">Email</label>
                    <input type="email" name="user-mail" id="user-mail" class="user" placeholder="you@example.com">

                    <div class="user-error-message"><?=$user_feedback;?></div>
                </div>

                <div class="form-input-container">
                    <label for="user-password" class="pass-lable">Password</label>
                    <input type="password" name="user-password" id="user-password" class="pass" placeholder="********">

                    <div class="pass-error-message"><?=$pass_feedback?></div>
                </div>

                <div class="details">
                    <a href="forgot-pass.php" class="forgot-pass">Forgot Password?</a>
                </div>

        
                <button type="submit" class="form-sign-in-button">Sign In</button>
                
                <div class="details-2">
                    <a href="sign-up.php" class="forgot-pass">Dont have an account?</a>
                </div>
            </form>
            </div>
        </div>
    </section>
</body>
</html>