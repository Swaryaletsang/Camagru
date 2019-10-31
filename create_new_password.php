<?php
   include("./userauth.php");
   $retrive = array();
   $cc = "";
   foreach($_GET as $key => $value)
      $retrive[$key] = $value;
   if ($retrive["selec"] && $retrive["validator"]) {
      $aa = new userauth();
      if (!($cc = $aa->checktoken($retrive['selec'], $retrive['validator'])))
      {
         header('location: login.php');
      }
   }else{
      header('location: login.php');
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Rest</title>
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
                <form action="resetpass.php" method="POST">
                    <p><input type="password" name="password" id="password" placeholder="Password" required></p>
                    <p><input type="re-password" name="re-password" id="re-password" placeholder="Password" required></p>
                    <p><input type="hidden" name="userid" value="<?php echo $cc[0]['userid']; ?>" placeholder="<?php echo $cc[0]['userid']; ?>"></p>
                    <p> <input type="submit" value="submit" name="submit"></p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>