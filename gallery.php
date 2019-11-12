<?php
//remove when doe or before marking
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    session_start();
    
    include("usermngt.php");
    if (!$_SESSION['userid'])
        header('location:login.php');
    if(isset($_POST['submitdelete']))
    {
        $var = new images();
        $pid = $_POST['submitdelete'];
        $var->deletepost($_SESSION['userid'] ,$pid);
    }
    include "connection.php";
    $numperpage = 5;
    $id = $_SESSION['userid'];
    $sql1 = "SELECT * FROM userimage WHERE userid = $id ORDER BY timess DESC";
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
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="main.css">
    <title>Profile</title>
</head>
<body>
    <div class="container">
        <?php
            include "./navigation/desp.php";
            include("./navigation/nev_private.php");
            echo "<br>";
               
            include_once('./picdb.php');
            $arr = new picdb();
            $display = $arr->getuser($_SESSION["userid"]);
          
            $i = 0;
            while($i < count($display))
            {
                echo '<div><img src="'.$display[$i]['images'].'" class="img" ><div>';
                echo " <form action='gallery.php' method= 'POST'>
                <button class='delete' type='submit' name='submitdelete' value='".$display[$i]['num']."'>Delete</button>
            </form>";             
            echo "</div>";
                $i++;
            }
            
        ?>
    </div>
    <form action="" method="POST">
            <?php
                for ($i = 1; $i <= $numlinks; $i++){
                    ?>
                    <input type="submit" value= "<?php echo $i;?>" name = "page">
                    <?php
                }?>
        </form>
    <?php
            include ('./footer/footer.php'); 
        ?>   
</body>
</html>