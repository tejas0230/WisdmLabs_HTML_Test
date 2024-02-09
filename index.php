<?php
session_start();
$class = "";
$btnClass ="";
$isUserLoggedIn = false;
if(isset($_SESSION['current_user']))
{
    $isUserLoggedIn = true;
    $class="";
    $btnClass = "hidden";
}
else
{
    $isUserLoggedIn = false;
    $class="hidden";
    $btnClass="";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="CSS/style.css?v=<?php echo time();?>">
</head>
<body>
    <section class="header">
        <div class="container">
            <div class="nav-bar">
                <a href="index.php" class="logo">Logo</a>
                <div class="nav-buttons">
                    <a href="sign-in.php" class="sign-in <?php
    if($isUserLoggedIn)
    {
        echo "hidden";
    }
    else
    {
        echo "";
    }
?>">Sign In</a>
                    <a href="logout.php" class="sign-in <?php
    if($isUserLoggedIn){
        echo "";
    }
    else
    {
        echo "hidden";
    }
?>">Logout</a>
                </div>
                <!-- <button class="sign-in" name="sign-in-button" onclick="">Sign In</button> -->
            </div>
        </div>
    </section>
    <section class="hero">
        <div class="container">
            <div class="hero-body">
                <div class="content-1">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
                <br>            
                <br>
                <div class="content-2 <?=$class;?>">
                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                </div>
                <br>
                <br>
                <a href="sign-in.php" class="see-more">Sign in to see more ...</a>
            </div>
        </div>
    </section>

</body>
</html>