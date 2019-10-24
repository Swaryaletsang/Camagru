<?php
    session_start();   
    include('./val.php');
    include('./usermngt.php');
    $retrive = array();
    $not_val = "";
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    $va = new va();
    $id = $va->get_user( $_SESSION['userid']);
    $uname = $retrive['username'];
    $name = $retrive['fullname'];
    $email = $retrive['email'];
    $password = $retrive['password'];
    $curentpassword = $retrive['curentpassword'];
    $pwd = $_SESSION['pwd'];
    echo $pwd;
    if ($retrive['submit'])
    {
        if ($pwd === $curentpassword)
        {
            $var = new createuser($retrive["email"], $retrive["name"], $retrive["username"], $retrive["password"]);
            $var->update_profile($id[0]['userid']);
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
                    <p><input type="email" name="email" id="email" placeholder="Edit Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Invalid email format" value="<?php echo $id['email'];?>"></p>
                    <p><input type="text" name="name" value="<?php echo $_SESSION['fname']?>" placeholder="Edit Full Name" id="name"></p>
                    <p> <input type="text" name="username" placeholder="Edit Username" id="username" value="<?php echo $_SESSION['userid']?>" pattern=[A-Za-z0-9]{6,}"></p>
                    <p><input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder=" Change Password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"></p>
                    <p><input type="password" name="curentpassword" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder=" Enter current Password" required></p>
                    <p><input type="submit" value="Update" name="submit" id="submit"></p>
                </form>
            </div>
    </div>

</body>

</html>