<?php
/**
 * Get the required classes
 */
require('connection.php');
require('user.php');


/**
 * Create objects / Get singleton instances
 */
$user = new User();
$db_obj = DBConn::getDBConn();

$confirm_pass_feedback ="";

//Get password reset token from URL
$token = $_GET['token'];

if($_SERVER["REQUEST_METHOD"]==="POST")
{
    //Get new pass and confirmed pass from the form
    $user_pass = $_POST['user-password'];
    $confirm_pass = $_POST['confirm-password'];

    if($user_pass===$confirm_pass)
    {
        $result = $user->UpdateUserPass($confirm_pass, $token, $db_obj);
        if($result===TRUE)
        {
            echo "<script>alert('Password Reset Successfully');document.location.href='sign-in.php';</script>";
        } 
    }
    else
    {
        $confirm_pass_feedback = "Passwords do not match";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Pass</title>
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
                <div class="form-title">Reset Password</div>


                <div class="form-input-container">
                    <label for="user-password" class="pass-lable">Enter new password</label>
                    <input type="password" name="user-password" id="user-password" class="pass" placeholder="********">

                    <div class="pass-error-message"></div>
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

                <div class="form-input-container">
                    <label for="user-password" class="pass-lable">Confirm new password</label>
                    <input type="password" name="confirm-password" id="confirm-password" class="pass" placeholder="********">

                    <div class="pass-error-message"><?=$confirm_pass_feedback?></div>
                </div>

                

        
                <button type="submit" class="form-sign-in-button">Reset Password</button>
                
            </form>
            </div>
        </div>
    </section>
    <script src="JS/index.js"></script>
</body>
</html>