<?php
    session_start(); 
    include("./navigation/desp.php");
    include("./navigation/nev_edituser.php");
    include('./usermngt.php');
    $retrive = array();
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    $va = new va();
    $id = $va->get_username($_SESSION['userid']);
    $chek = $va->fetc_pref($id[0]['userid']);
    $cheked = $chek[0]['pref'];
    if (!$_SESSION['userid'])
        header('Location: login.php');
    if (isset($retrive['submit']))
    {
        $uname = $retrive['username'];
        $name = $retrive['name'];
        $email = $retrive['email'];
        $password = $_POST['password'];
        $curentpassword = $retrive['curentpassword'];
        if ($id[0]['passwd'] === hash("md5",$curentpassword))
        {
         
            if(!$email && !$name && !$uname && !$password){
                $error_msg = "Nothing changed";
                echo $error_msg;
            }  
            else{
                if (!$email)
                    $email = $id[0]['email'];
                if (!$password)
                    $password = $id[0]['passwd'];
                if (!$name)
                    $name = $id[0]['fullname'];
                if (!$uname)
                    $uname = $id[0]['username'];
                if ($email || $name || $uname || $password){
                    if ($va->test_email($email) || $va->test_user($uname) || $password ){;
                        if($password !=  $id[0]['passwd'])
                           $password = hash("md5",$password);
                        $var = new createuser($email, $name, $uname, $password);
                        $var->update_profile($_SESSION['userid']);
                        echo '<center>Profile Updated</center>'; 
                    }
                    else {
                        if ($_POST['email'])
                            echo "Email already exist!";
                        if ($_POST['username'])
                            echo "Username already exist!";
                    }
                }
                if ($cheked === 1){
                    if ($_POST['name'])
                        mail($id[0]['email'], "CAMAGRU account updated", "Hi " .$id[0]['username'].",\n\nYou have changed your fullname.\n\nRegards\nCAMAGRU", "FROM:(CAMAGRU)camagruca@gmail.com");
                    if ($_POST['email'])
                        mail($id[0]['email'], "CAMAGRU account updated", "Hi " .$id[0]['username'].",\n\nYou have changed your Email.\n\nRegards\nCAMAGRU", "FROM:(CAMAGRU)camagruca@gmail.com");
                    if ($_POST['username'])
                        mail($id[0]['email'], "CAMAGRU account updated", "Hi " .$id[0]['username'].",\n\nYou have changed your username.\n\nRegards\nCAMAGRU", "FROM:(CAMAGRU)camagruca@gmail.com");
                    if ($_POST['password'])
                        mail($id[0]['email'], "CAMAGRU account updated", "Hi " .$id[0]['username'].",\n\nYou have changed your password.\n\nRegards\nCAMAGRU", "FROM:(CAMAGRU)camagruca@gmail.com");
                }
                    
            }    
             
        }
    }
    if (isset($_POST['prfn']))
    {
        if (isset($_POST['email_preference'])){
            include('./connection.php');
            $sql = 'UPDATE users SET pref = 1 WHERE userid = :userid';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":userid", $_SESSION['userid']);            
            $stmt->execute();
            echo "Email preferences changed";
        
        }
        else {
            include('./connection.php');
            $sql = 'UPDATE users SET pref = 0 WHERE userid = :userid';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":userid", $_SESSION['userid']);            
            $stmt->execute();
            echo "Email preferences changed";
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
    <title>Edit Account</title>
</head>

<body>
    <div style="width:300px; height:350px; margin:auto; background-color:#A0C2FA; zoom:1;">
                <p calass ="he">
                    <h1>Update Profile</h1>
                </p>
                <form action="" method="post">
                    <p class ="he"><input type="email" name="email" placeholder=<?php echo $id[0]['email'];?> pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email format"></p>
                    <p class ="he"><input type="text" name="name" placeholder="<?php echo $id[0]['fullname'];?>"></p>
                    <p class="he"> <input type="text" name="username" placeholder=<?php echo $id[0]['username'];?> pattern="[A-Za-z0-9]{6,}"></p>
                    <p class="he"><input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder=" Change Password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"></p>
                    <p class="he"><input type="password" name="curentpassword"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder=" Enter current Password" required></p>
                    <p class="he"><input type="submit" value="Update" name="submit"></p>
                </form>
                <form action="" method="POST">
                    <p class="he"><input type="checkbox" name="email_preference" <?php echo ($cheked == 1)?"checked":"";?>> Receive email Notification?</p>
                    <p class = 'he'><input type="submit" value="Change Email Preferences" name="prfn" id="submit"></p>
                </form>
    </div> 
    <?php include('./footer/footer.php'); ?>

</body>

</html>
