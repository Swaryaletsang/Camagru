<?php
    include("./connection.php");
    try
    {
        $sql = "CREATE TABLE IF NOT EXISTS users(
            userid  INT(10) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50),
            fullname VARCHAR(50),
            email VARCHAR(50),
            passwd VARCHAR(300));";
        $conn->exec($sql);
        $sql = "CREATE TABLE IF NOT EXISTS temptoken(
            userid  INT(10) AUTO_INCREMENT PRIMARY KEY,
            selec VARCHAR(50),
            token VARCHAR(50));";
        $conn->exec($sql);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = NULL;
?>