
<?php
    session_start();
    include_once('./userauth.php');
    $retrive = array();
    $not_val = "";
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    if ($retrive["username"] && $retrive["password"] && $retrive["submit"]) {
        $va = new userauth();
        echo $va->checklogin($retrive['username'], $retrive['password']);
        if ($va->checklogin($retrive['username'], $retrive['password'])){
            $val = $va->getuserid($retrive["username"]);
            $_SESSION['username'] = $val[0]['userid'];
            header("Location: publicgallery.php");
        }
        else{
            $not_val = "incorect username or password";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>
    <div class="Container">
        <div class="box-1">
            <div>
                <p>
                    <h1>CAMAGRU</h1>
                </p>
            </div>
            <div class="form_reg"> 
                <div><?php echo $not_val;?></div>
                <form action="login.php" method="POST">
                    <p><input type="text" name="username" placeholder="Username or Email" id="username" required></p>
                    <p><input type="password" name="password" id="password" placeholder="Password" required></p>
                    <p> <input type="submit" value="Login" name="submit" id="submit"></p>
                </form>
            </div>
            <div>
                <p> <a href="forgotpass.php">forgot password</a></p>
            </div>
        </div>
        <div class="box-2">
            <p>Don't have an account? <a href="registration.php">Sign up</a></p>
        </div>
    </div>

</body>

</html>