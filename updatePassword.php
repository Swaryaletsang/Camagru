<?php
include("connection.php");
include("val.php");
include("send_mail.php");
$password = $_POST['password'];
$email = $_POST['email'];
echo "1";
if ($_POST['submit']){
    echo "2";
    $update = new va();
    if(($update->test_password($password))){
        $update->updatePassword($password, $email);
        header("location: login.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>
<body>
    <form action="updatePassword.php" method="POST">
        new password<input type="password" name="password" placeholder="new password">
        email<input type="text" name="email" placeholder="email">
        <input type="submit" name="submit" value="reset">
    </form>
</body>
</html>
