<?php
include('./val.php');
include('./usermngt.php');
include('./navigation/nev_register.php');
$retrive = array();
foreach($_POST as $key => $value)
    $retrive[$key] = $value;
if ($retrive["email"] && $retrive["name"] && $retrive["username"] && $retrive["password"] && $retrive["submit"]) {
    $va = new va();
    if ($va->test_email($retrive['email']) && $va->test_password($retrive['password']) && $va->test_user($retrive['username']))
    {
        echo "f";
        $var = new createuser($retrive["email"], $retrive["name"], $retrive["username"], $retrive["password"]);
        $var->tbuser();
        $var->add_user();
        // header("location: Login.php");
    }
    else {
        echo "Username or Email already exist!";
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
    <title>User_Registration</title>
</head>

<body>
    <div style="width:100%;">
      
            <div style="width:300px; height:350px; margin:auto; background-color:#A0C2FA; zoom:1;"> 
                <p class = "he">
                    <h1>CAMAGRU</h1>
                </p>
          
                <form action="Register.php" method="post">
                    <p class = "he"><input type="email" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email format" required></p>
                    <p class = "he"><input type="text" name="name" placeholder="Full Name" id="name"></p>
                    <p class = "he"> <input type="text" name="username" placeholder="Username" id="username" pattern="[A-Za-z0-9]{6,}" required></p>
                    <p class = "he"><input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password" required title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"></p>
                    <p class = "he"><input type="submit" value="Sign Up" name="submit" id="submit"></p>
        
                    <p class = "he">Have an account? <a href="Login.php">Login</a></p>
            </div>         
    </div>
    
    <?php include('./footer/footer.php'); ?>
</body>

</html>