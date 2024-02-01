<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "tejas";
$dbname = "user";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

$feedback="";

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


function CheckUserExists($user_mail,$conn)
{
    $sql = "SELECT * from user where user_email = '{$user_mail}'";
    $result = $conn->query($sql);
    if($result->num_rows>0)
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
        $feedback = "User already exist - Sign In";
    }
    else
    {
        $sql = "INSERT into user (user_name,user_email,user_pass) values ('$user_name','$user_mail','$user_pass')";
        $result = $conn->query($sql);
        if($result===TRUE)
        {
            $_SESSION['current_user'] = $user_mail;
            header("Location:index.php");
        }
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
                <div class="form-title">Sign Up</div>

                <div class="form-input-container">
                    <label for="user-mail" class="user-lable">Email</label>
                    <input type="email" name="user-mail" id="user-mail" class="user" placeholder="i.e. you@example.com">

                    <div class="user-error-message"><?=$feedback;?></div>
                </div>

                <div class="form-input-container">
                    <label for="user-mail" class="user-name">Username</label>
                    <input type="text" name="user-name" id="user-name" class="user" placeholder="i.e. Username">

                    <div class="user-error-message hidden">User does not exist!</div>
                </div>

                <div class="form-input-container">
                    <label for="user-password" class="pass-lable">Password</label>
                    <input type="password" name="user-password" id="user-password" class="pass" placeholder="********" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">

                    <div class="pass-error-message hidden">Password is incorrect</div>
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

        
                <button type="submit" value="sign-up" class="form-sign-up-button" name="sign-up-button">Sign Up</button>
                
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