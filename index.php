<?php
    session_start();
    error_reporting(0);
    include "connection.php";
    include ('val.php');
    if (isset($_SESSION['userid'])){
        $bar = new va;
        $id = $bar->get_user($_SESSION['userid']);
        $uid = $id[0]['userid'];
        $retrive = array();
        $not_val = "";
        foreach($_POST as $key => $value)
        {
            $retrive[$key] = $value;
        }
    
    
    if (isset($_SESSION["userid"])  && isset($_POST["submit"]))
    {
        if($retrive['comment'] && $retrive['userid'] && $_SESSION['userid'] && $retrive['imagenu'])
        {
            include_once('commentnlike.php');
            
            $reciever_id = $retrive['userid'];
            
            $image_owner = $bar->get_otherUser($reciever_id);
            
            $ad = new commentnlike();
            $ad->addcomment($retrive['comment'], $uid, $retrive['userid'], $retrive['imagenu']);
            if ($image_owner['preference'] == 1)
            {
                $ad->emailcomment($reciever_id, 'comment');
            }
            unset($ad);
            header('location: index.php');
        }
    }elseif (isset($_SESSION["userid"]) && isset($_POST['like']))
    {
        if($retrive['like'] && $_SESSION['userid'])
        {
            include_once('commentnlike.php');
            $ad = new commentnlike();
            $ad->addlike($uid, $retrive['like'], $retrive['imagenu']);
            $ad->emailcomment($uid, 'like');
            unset($ad);
            header('location: index.php');
        }
    }
}
    $numperpage = 5;
    $sql1 = "SELECT * FROM userimage ORDER BY timess DESC";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    $re = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt1->fetchAll();

    $numrecords = count($rows);
    $numlinks = ceil($numrecords/$numperpage);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
     <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="flexboxgrid.css"> -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h1 class="logo">INSTAGRU</h1>
    <nav class="nav_links">
        <?php
            if (isset($_SESSION["userid"]))
            {
                echo '<ul><li><a href="gallery.php">Profile</a></li> 
                        <li><a href="logout.php">logout</a></li></ul>';
            }else
            {
                echo '<ul><li><a href="login.php">login</a></li> ';
                echo '<li><a href="register.php">Register</a></li><ul>';
            }
        ?>
    </nav>
</header>
<main class="imgs" style="width:100%;">
        <?php
            include_once('./picdb.php');
            include_once('commentnlike.php');
            $hold = new commentnlike();
            $arr = new picdb();
            $display = $arr->getall();
            $i = 0;
            while($i < count($display))
            {
                echo '<div ><div style="width:100%;"><img src="'.$display[$i]['images'].'"></div>';
                if(isset($_SESSION['userid']))
                {
                    $lik = count($hold->getlikes($display[$i]['num']));

                    $holds = $hold->getcomments($display[$i]['num']);
                    echo '<div id="'.$display[$i]['timess'].'"><button style="margin-left: 30%;" disabled id="'.$display[$i]['timess'].'" onclick="displays('.$display[$i]['num'].','.$display[$i]['timess'].')">comments: '.count($holds).'</button>';
                    echo '<form action="index.php" method="post"><button id="'.$display[$i]['timess'].'" type="submit" style="margin-left: 30%;" name="like" value="'.$display[$i]['userid'].'">like '.$lik.'</button>';
                    echo '<input type="hidden" name="imagenu" value="'.$display[$i]['num'].'"></form></div><br/>';
                    echo '<div id="'.$display[$i]['num'].'" >';
                    $j = 0;
                    while($j < count($holds))
                    {
                       echo '<textarea style="width:30%; margin-left: 30%; margin-right: 30%;" rows="4" cols="50" disabled>'.$holds[$j]['comment'].'</textarea>';
                       $j++;
                    }
                    echo '<form action="index.php" method="post"><textarea style="width:40%; margin-left: 30%; margin-right: 30%;" name="comment"  id="'.$display[$i]['num'].'" rows="4" cols="50"></textarea>';
                    echo '<input type="hidden" name="userid" value="'.$display[$i]['userid'].'">';
                    echo '<input type="hidden" name="imagenu" value="'.$display[$i]['num'].'">';
                    echo '<button style="margin-left: 30%;" type="submit" value="comment" id="'.$display[$i]['num'].'" name="submit">comment</button></form></div>';
                    unset($holds);
                }
                echo '</div>';
                $i++;
            }
            unset($hold); 
        ?>
            <div class="page">
                <form action="" method="POST">
            <?php
                for ($i = 1; $i <= $numlinks; $i++){
                    ?>
                    <input type="submit" value= "<?php echo $i;?>" name = "page">
                    <?php
                }?>
        </form>
            </div>
        
</main>
    
        <footer>
            <div class="footer">
                <h3>Instagru</h3>
                <p>&copy atau 2019</p>
            </div>
 
        </footer>
</body>
</html>