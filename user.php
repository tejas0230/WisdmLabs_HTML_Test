<?php
    
    class User
    {
        public function __construct()
        {

        }

        public function CheckUserExists($user_mail,$db_obj)
        {
            $sql = "SELECT * from user where user_email = '{$user_mail}'";
            $result = $db_obj->query($sql);
            if($result->num_rows===1) {
                return true;
            } 
            else
            {
                return false;
            }
        }

        public function GenerateToken()
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


        public function SignUpUser($user_mail,$user_name,$user_pass,$db_obj)
        {
            $sql = "INSERT into user (user_name,user_email,user_pass) values ('$user_name','$user_mail','$user_pass')";
            $result = $db_obj->query($sql);
            return $result;
        }

        public function GetUserPassword($user_mail,$db_obj)
        {
            $sql = "SELECT * from user where user_email = '{$user_mail}'";
            $result = $db_obj->query($sql);
            $row  = $result->fetch_assoc();
            return $row['user_pass'];
        }

        public function UpdateUserPass($newPass,$token,$db_obj)
        {
            $sql = "UPDATE user set user_pass='$newPass' where token='$token'";
            $result = $db_obj->query($sql);
            return $result;
        }

        public function TrimAndSanitizeEmail($user_mail)
        {
            //sanitaize data - remove white spaces from starting and end
            $user_mail = trim($user_mail);
            //sanitaize data - remove dangerous characters to prevent HTML injection
            $user_mail = filter_var($user_mail, FILTER_SANITIZE_EMAIL);
            return $user_mail;
        }
    }
?>
