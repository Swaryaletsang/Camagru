<?php
//remove when doe or before marking
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    session_start();
    include("val.php");
    include("usermngt.php");
    $va = new va();
    $id = $va->get_user($_SESSION['userid']);
    if(isset($_POST['submitdelete']))
    {
        $var = new images();
        $uid = $id[0]['userid'];
        $pid = $_POST['submitdelete'];
        $var->deletepost($uid ,$pid);
    }

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
            $var = new va;
            $id = $var->get_user($_SESSION['userid']);
            $uid = $id[0]['userid'];
           
            include_once('./picdb.php');
            $arr = new picdb();
            $display = $arr->getalluser($uid);
          
            $i = 0;
            while($i < count($display))
            {
                echo '<div><img src="'.$display[$i]['images'].'" style="width: 450px; hight: 450px; margin-left: 450px;" ><div>';
                echo " <form action='gallery.php' method= 'POST'>
                <button class='button' type='submit' name='submitdelete' value='".$display[$i]['num']."'>Delete</button>
            </form>";             
            echo "</div>";
                $i++;
            }
            
        ?>
    </div>
    <div>
    <a href="cam.php">cam</a>
    <a href="logout.php">logout</a>
    <a href="contents.php">upload</a>
    <a href="modify.php">edituser</a>
    <a href="index.php">public</a>
    </div>
</body>
</html>