<?php
    session_start();
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    include ('val.php');
    $bar = new va;
    $id = $bar->get_user($_SESSION['userid']);
    $uid = $id[0]['userid'];
    $retrive = array();
    $not_val = "";
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    if ($_SESSION["userid"]  && $retrive["submit"])
    {
        if($retrive['comment'] && $retrive['userid'] && $_SESSION['userid'] && $retrive['imagenu'])
        {
            include_once('commentnlike.php');
            $ad = new commentnlike();
            $ad->addcomment($retrive['comment'], $uid, $retrive['userid'], $retrive['imagenu']);
            $ad->emailcomment($uid, 'comment');
            unset($ad);
        }
    }elseif ($_SESSION["userid"] && $retrive['like'])
    {
        if($retrive['like'] && $_SESSION['userid'])
        {
            include_once('commentnlike.php');
            $ad = new commentnlike();
            $ad->addlike($uid, $retrive['like'], $retrive['imagenu']);
            $ad->emailcomment($uid, 'like');
            unset($ad);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>

</head>
<body>
    <div>
        <?php
            include_once('./picdb.php');
            include_once('commentnlike.php');
            $hold = new commentnlike();
            $arr = new picdb();
            $display = $arr->getall();
            $i = 0;
            while($i < count($display))
            {
                echo '<div style="width: 450px; hight: 450px; margin-left: 450px; margin-bottom: 30px;"><div><img src="'.$display[$i]['images'].'" style="width: 450px; hight: 450px;"></div>';
                if($_SESSION['userid'])
                {
                    $lik = count($hold->getlikes($display[$i]['num']));

                    $holds = $hold->getcomments($display[$i]['num']);
                    echo '<div id="'.$display[$i]['timess'].'"><button id="'.$display[$i]['timess'].'" onclick="displays('.$display[$i]['num'].','.$display[$i]['timess'].')">comment '.count($holds).'</button>';
                    echo '<form action="index.php" method="post"><button id="'.$display[$i]['timess'].'" type="submit" name="like" value="'.$display[$i]['userid'].'">like '.$lik.'</button>';
                    echo '<input type="hidden" name="imagenu" value="'.$display[$i]['num'].'"></form></div><br/>';

                    echo '<div id="'.$display[$i]['num'].'" style="display:none;">';
                    $j = 0;
                    while($j < count($holds))
                    {
                       echo '<textarea rows="4" cols="50" disabled>'.$holds[$j]['comment'].'</textarea>';
                       $j++;
                    }
                    echo '<form action="index.php" method="post"><textarea name="comment"  id="'.$display[$i]['num'].'" rows="4" cols="50"></textarea>';
                    echo '<input type="hidden" name="userid" value="'.$display[$i]['userid'].'">';
                    echo '<input type="hidden" name="imagenu" value="'.$display[$i]['num'].'">';
                    echo '<button type="submit" value="comment" id="'.$display[$i]['num'].'" name="submit">comment</button></form></div>';
                    unset($holds);
                }
                echo '</div>';
                $i++;
            }
            unset($hold); 
        ?>
    </div>
    <div>
    <?php
        if ($_SESSION["userid"])
        {
            echo '<a href="gallery.php">Profile</a> ';
            echo '<a href="logout.php">logout</a>';
            // echo $_SESSION["username"];
        }else
        {
            echo '<a href="login.php">login</a> ';
            echo '<a href="register.php">Register</a>';
        }
    ?>
    </div>
    <script>
        function displays($val, $datess)
        {
            document.getElementById($val).style.display = "initial";
            document.getElementById($datess).style.display = "none";
        }
    </script>
</body>
</html>