<?php
$servername = "localhost";
$username = "root";
$password = "tejas";
$dbname = "user";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

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
    $user_mail = $_POST['user-mail'];
    $user_name = $_POST['user-name'];
    $user_pass = $_POST['user-password'];

    if(CheckUserExists($user_mail,$conn))
    {
        echo "user already exist";
    }
    else
    {
        $sql = "INSERT into user (user_name,user_email,user_pass) values ('$user_name','$user_mail','$user_pass')";
        $result = $conn->query($sql);
        if($result===TRUE)
        {
            header("Location:index.php");
        }
    }
}
$conn->close();

?>