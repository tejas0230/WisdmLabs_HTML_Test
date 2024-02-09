<?php
session_start();
require('connection.php');

require('user.php');
$user = new User();

$db_obj = DBConn::getDBConn();

$feedback="";
$passError="";

function CheckPassword($user_pass)
{
    $lower = "/[a-z]/";
    $upper = "/[A-Z]/";
    $numbers = "/[0-9]/";
    $special = "/[!@#$%^&*()<>,.?{}]/";
    if(preg_match($lower,$user_pass)===1 && preg_match($upper,$user_pass)===1&&preg_match($numbers,$user_pass)&&preg_match($special,$user_pass)===1&&strlen($user_pass)>=8)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}


if($_SERVER["REQUEST_METHOD"]==="POST")
{
    //get data from form
    $user_mail = $_POST['user-mail'];
    $user_name = $_POST['user-name'];
    $user_pass = $_POST['user-password'];

    //sanitaize data - remove white spaces from starting and end
    $user_pass = trim($user_pass); 
    $user_mail = $user->TrimAndSanitizeEmail($user_mail);

    if(!filter_var($user_mail, FILTER_VALIDATE_EMAIL))
    {
        $feedback = "Invalid Email";
        return 1;
    }
    if($user->CheckUserExists($user_mail,$db_obj))
    {
        $feedback = "User already exists - Sign In";
    }
    else
    {
        if(CheckPassword($user_pass))
        {
            $hashPass = sha1($user_pass);
            $result = $user->SignUpUser($user_mail,$user_name,$hashPass,$db_obj);
            if($result===TRUE)
            {
                $_SESSION['current_user'] = $user_mail;
                header("Location:index.php");
            }
        }
        else
        {
            $passError = "Password should match the pattern";
        }
    }
}
$db_obj->close();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                <div class="form-title">Sign Up</div>

                <div class="form-input-container">
                    <label for="user-mail" class="user-lable">Email</label>
                    <input type="email" name="user-mail" id="user-mail" class="user" placeholder="i.e. you@example.com" required>

                    <div class="user-error-message"><?=$feedback;?></div>
                </div>

                <div class="form-input-container">
                    <label for="user-mail" class="user-name">Username</label>
                    <input type="text" name="user-name" id="user-name" class="user" placeholder="i.e. Username" required>

                    <div class="user-error-message hidden">User does not exist!</div>
                </div>

                <div class="form-input-container">
                    <label for="user-password" class="pass-lable">Password</label>
                    <input type="password" name="user-password" id="user-password" class="pass" placeholder="********" required>

                    <div class="pass-error-message"><?=$passError?></div>
                </div>

                <div id="message">
                    <h4>Password must</h3>
                    <ul>
                        <li id="lower" class="invalid">Contain a <b>lowercase</b> letter</li>
                        <li id="upper" class="invalid">Contain a <b>capital</b> letter</li>
                        <li id="number" class="invalid">Contain a <b>number</b> </li>
                        <li id="special" class="invalid">Contain a <b>special</b> character</li>
                        <li id="length" class="invalid">Be atleast <b>8</b> character long</li>
                    </ul>
                </div>

        
                <button  value="sign-up" class="form-sign-up-button" name="sign-up-button">Sign Up</button>
                
                <div class="details-2">
                    <a href="sign-in.php" class="forgot-pass">Already have an account?</a>
                </div>
            </form>
            </div>
        </div>
    </section>

    <script src="JS/index.js"></script>

</body>
</html>