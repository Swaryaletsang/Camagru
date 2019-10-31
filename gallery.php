<?php
    include_once('./sessionmanagement.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
</head>
<body>
    <div>
        <?php
            include_once('./picdb.php');
            $arr = new picdb();
            $display = $arr->getalluser($_SESSION["username"]);
            $i = 0;
            while($i < count($display))
            {
                echo '<div><img src="'.$display[$i]['images'].'" style="width: 450px; hight: 450px; margin-left: 450px;" ><div>';
                $i++;
            } 
        ?>
    </div>
    <div>
    <a href="cam.php">cam</a>
    <a href="logout.php">logout</a>
    <a href="upload.php">upload</a>
    <a href="edituser.php">edituser</a>
    <a href="publicgallery.php">public</a>
    </div>
</body>
</html>