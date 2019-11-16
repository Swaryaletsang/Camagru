<?php
   include('database.php');
if ($count == 1){

    $myfile = fopen("../camagru.sql", "r") or die("Unable to open file!");
    $sql2 = fread($myfile,filesize("../camagru.sql"));
    fclose($myfile);

    try {
        $conn = new PDO("mysql:host=".$servername.";dbname=camagru;", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql2);
        echo "Success";
     }
     catch(PDOException $e)
     {
        echo "Connection failed: " . $e->getMessage();
     }

}else{
    echo $ret; 
}


?>
