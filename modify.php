<?php
//remove when doe or before marking
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    session_start();   
    include('./val.php');
    include('./usermngt.php');

    $retrive = array();
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    $var = new createuser($email, $name, $uname, $password);
    $va = new va();
    $id = $va->get_user($_SESSION['userid']);
    $uname = $retrive['username'];
    $name = $retrive['name'];
    $email = $retrive['email'];
    $password = $retrive['password'];
    $curentpassword = $retrive['curentpassword'];
    $pwd = $_SESSION['pwd'];
    $chek = $va->fetc_pref($id[0]['userid']);
    $cheked = $chek[0]['pref'];
    if (!$_SESSION['userid'])
        header('Location: login.php');
    if ($retrive['submit'])
    {
        if ($pwd === $curentpassword )
        {
            if(!$email && !$name && !$uname && !$password){
                $error_msg = "Nothing changed";
                echo $error_msg;
            }  
            else{
                if (!$email)
                    $email = $id[0]['email'];
                if (!$password)
                    $password = $pwd;
                if (!$name)
                    $name = $id[0]['fullname'];
                if (!$uname)
                    $uname = $id[0]['username'];
                if ($email || $name || $uname || $password){
                    if ($va->test_email($retrive['email']) || $va->test_password($retrive['password']) || $va->test_user($retrive['username'])){
                        $var->update_profile($id[0]['userid']); 
                    }
                    else {
                        if ($_POST['email'])
                            echo "Email already exist!";
                        if ($_POST['username'])
                            echo "Username already exist!";
                    }
                }
                if ($cheked == 1){
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
            $stmt->bindParam(":userid", $id[0]['userid']);            
            $stmt->execute();
        
        }
        else {
            include('./connection.php');
            $sql = 'UPDATE users SET pref = 0 WHERE userid = :userid';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":userid", $id[0]['userid']);            
            $stmt->execute();
        }     
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Account</title>
</head>

<body>
    <div class="Container">
        <div class="box-1">
            <div>
                <p>
                    <h1>EDIT ACCOUNT</h1>
                </p>
            </div>
            <div class="form_reg">
                <form action="" method="post">
                    <p><input type="email" name="email" id="email" placeholder=<?php echo $id[0]['email'];?> pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email format"></p>
                    <p><input type="text" name="name" placeholder="<?php echo $id[0]['fullname'];?>" id="name"></p>
                    <p> <input type="text" name="username" placeholder=<?php echo $id[0]['username'];?> id="username" pattern="[A-Za-z0-9]{6,}"></p>
                    <p><input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder=" Change Password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"></p>
                    <p><input type="password" name="curentpassword" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder=" Enter current Password" required></p>
                    <p><input type="submit" value="Update" name="submit" id="submit"></p>
                </form>
                <form action="" method="POST">
                    <p><input type="checkbox" name="email_preference" <?php echo ($cheked == 1)?"checked":"";?>> Receive email Notification?</p>
                    <p><input type="submit" value="Change Email Preferences" name="prfn" id="submit"></p>
                </form>
            </div>
    </div>

</body>

</html>
