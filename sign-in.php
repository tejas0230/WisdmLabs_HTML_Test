<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "tejas";
$dbname = "user";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

$user_feedback="";
$pass_feedback = "";
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


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

function GetUserPassword($user_mail,$conn)
{
    $sql = "SELECT * from user where user_email = '{$user_mail}'";
    $result = $conn->query($sql);
    if($result->num_rows===1)
    {
        $row  = $result->fetch_assoc();
        return $row['user_pass'];
    }
}



if($_SERVER["REQUEST_METHOD"]==="POST")
{
    //get data from form
    $user_mail = $_POST['user-mail'];
    $user_pass = $_POST['user-password'];

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
        $pass = GetUserPassword($user_mail,$conn);
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
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/style.css">
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
                    <a href="" class="forgot-pass">Forgot Password?</a>
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