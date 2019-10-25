<?php
session_start();
include('./val.php');
    $retrive = array();
    $not_val = "";
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    if ($retrive["username"] && $retrive["password"] && $retrive["submit"]) {
        $va = new va();
        if ($va->valid_login($retrive['username'], $retrive['password'])){
            $_SESSION['userid'] = $retrive["username"];
            $_SESSION['pwd'] = $retrive['password'];
            $_SESSION['email'] = $retrive['email'];
            $_SESSION['name'] = $retrive['fullname'];
           header("location: contents.php");
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
                <form method="POST">
                    <p><input type="text" name="username" placeholder="Username or Email" id="username" required></p>
                    <p><input type="password" name="password" id="password" placeholder="Password" required></p>
                    <p> <input type="submit" value="Login" name="submit" id="submit"></p>
                </form>
            </div>
            <div>
                <p> <a href="forgotPass.php"> forgot password</a></p>
            </div>
        </div>
        <div class="box-2">
            <p>Don't have an account? <a href="Register.php">Sign up</a></p>
        </div>
    </div>

</body>

</html>