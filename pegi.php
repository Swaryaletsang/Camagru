<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
    include ('connection.php');

    $numperpage = 5;
    $page = 0;
    if (isset($_POST["page"]))
    {
        $page = $_POST["page"];
        $page = ($page * $numperpage) - $numperpage;
    }
    
        $sql = "SELECT * FROM userimage ORDER BY timess DESC LIMIT {$page},{$numperpage} ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $images = $stmt->fetchAll();
        
        foreach ($images as $val)
            echo '<div><img src="'.$val['images'].'" style="width: 450px; hight: 450px; margin-left: 450px;" ><div>';

        $sql1 = "SELECT * FROM userimage ORDER BY timess DESC";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute();
        $re = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt1->fetchAll();

        $numrecords = count($rows);
        $numlinks = ceil($numrecords/$numperpage);

?>
<html>
    <body>
        <form action="" method="POST">
            <?php
                for ($i = 1; $i <= $numlinks; $i++){
                    ?>
                    <input type="submit" value= "<?php echo $i;?>" name = "page">
                    <?php
                }?>
        </form>
    </body>
</html>