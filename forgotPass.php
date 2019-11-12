<?php
    include("password_email_reset.php");
    include('./navigation/nev_forgp.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header.css">
    <title>Reset Password</title>
</head>
<body>
    <div style="width:300px; height:300px; margin:auto; background-color:#A0C2FA; zoom:1;">
    <div style ="margin: 0px 25px 20px 20px;">
        <p>Enter your Email to reset Password</p>
        <form action="password_email_reset.php" method="POST">
        <p><input type="email" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email format" required></p>
        <input type="submit" value="send link" name="submit">
        </form>
    </div>
    </div>
<!-- <div style="margin-top:40%;"> -->
    <?php include('./footer/footer.php'); ?>
<!-- </div> -->

</body>

</html>