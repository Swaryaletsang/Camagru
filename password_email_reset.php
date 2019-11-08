<?php
    include("val.php");
    include("send_mail.php");
    include("connection.php");
    if($_POST['submit']){
        echo "2";
        $email = $_POST['email'];
        if ($email){
            $valid = new va();
            echo "3";
            if ($valid->email_verified($email)){
                $vkey = md5(time());
                $mail = new send_mail("$email","<a href=http://localhost:8080/Instagru/resetPassword.php?vkey=$vkey>reset password</a>" ,"password reset");
                $mail->send_mail();
                $sql = 'UPDATE users SET vkey = :vkey WHERE email = :email'; echo 'a';
                $stmt = $conn->prepare($sql); echo 'b';
                $stmt->bindParam(":vkey", $vkey);  echo 'c';
                $stmt->bindParam(":email", $email);
                $stmt->execute(); echo 'g';
                header("location: passMessage.php");
            }
           else{
               echo "email not registered";
           }
        }
        else{
            echo "no email entered";
        }
    }
?>