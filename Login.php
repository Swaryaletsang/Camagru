<?php 
session_start();
include('./navigation/nev_login.php');
include "val.php";
    $retrive = array();
    $not_val = "";
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    if (isset($retrive["submit"])){

        if ($retrive["username"] && $retrive["password"]) {
            $va = new va();
            if ($va->valid_login($retrive['username'], $retrive['password'])){
                if ($va->email_verified($retrive['username'])){
                    $id = $va->get_user($retrive["username"]);
                    $uid = $id[0]['userid'];
                    $_SESSION['userid'] = $uid;
                    header("location: index.php");
                }      
                else
                    echo "confirm account first";
            }
            else{
                $not_val = "incorect username or password";
            }
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
    <link rel="stylesheet" href="header.css">
    <style>
        .he, h1{
            margin-left: 60px;
        }
    </style>
    <title>Login</title>
</head>

<body>
    <div style="width:100%;">
        <div style="width:300px; height:300px; margin:auto; background-color:#A0C2FA; zoom:1;">
            
                <p class="he">
                    <h1>CAMAGRU</h1>
                </p>

                <div><?php echo $not_val;?></div>
                <form method="POST" style="">
                    <p class="he"><input type="text" name="username" placeholder="Username" id="username" required></p>
                    <p class="he"><input type="password" name="password" id="password" placeholder="Password" required></p>
                    <p class="he"><input type="submit" value="Login" name="submit" id="submit"></p>
                </form>
                <p class="he"><a href="forgotPass.php"> forgot password</a></p>
                <p class="he">Don't have an account? <a href="Register.php">Sign up</a></p> 
          
        </div>
    </div>
    <?php include('./footer/footer.php'); ?>

</body>

</html>