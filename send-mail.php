<?php
    
use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
    class MailSender
    {

        public function SendMailToUser($user_mail,$token)
        {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username='';
            $mail->Password = '';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465; 

            $mail->setFrom('');
            $mail->addAddress($user_mail);
            $mail->isHTML(true);
            $mailBody = "Please follow the link to reset your password\n http://localhost/WisdmLabs/WisdmLabs_HTML_Test/forgot.php?token={$token}";
            $mail->Subject = "Password reset link";
            $mail->Body = $mailBody;

            if($mail->send())
            {
                return true;
            }
        }
    }
?>