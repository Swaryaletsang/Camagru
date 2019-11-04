<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
/*
    BECAUSE OF A LOT OF BUGS FROM THE OOP METHOD, PROCEDURAL W 
*/
include("val.php");
$db_servername = "localhost";
$db_username = "root";
$db_password = "123456";
try {
       $conn = new PDO("mysql:host=".$db_servername.";dbname=camagru", $db_username, $db_password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
       echo "Connection failed: " . $e->getMessage();
}
$key = $reponse = null;
if (isset($_GET['vkey']))
{
    $key = $_GET['vkey'];
}
if (isset($_POST['reset_password_submit']))
{
    $password = $_POST['password'];
    $password_retype = $_POST['password_retype'];
    if (empty($password) || empty($password_retype))
    {
        $reponse = "missing input";
    }
    else if ($password !== $password_retype)
    {
        $reponse = "password don't match";
    }
    else{
        $valid = new va();
        if($valid->test_password($password)){
            $password = md5($password);
            $sql = "UPDATE users SET passwd = ? WHERE vkey = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $password);
            $stmt->bindParam(2, $key);
            $stmt->execute();
            header("location: login.php");
        }
        else
            echo "make it stronger";  
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p><?php echo $reponse; ?></p>
    <form action="?vkey=<?php echo $key; ?>" method="POST">
        <label>new password</label><br>
        <input type="password" name="password" placeholder="new password"><br>
        <label>retype password</label><br>
        <input type="password" name="password_retype" placeholder="retype password"><br>
        <input type="submit" name="reset_password_submit" value="reset password">
    </form>
</body>
</html>