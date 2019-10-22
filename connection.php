<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
try {
    $conn = new PDO("mysql:host=".$servername, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    $conn->exec($sql);
    $conn = null;
    $conn = new PDO("mysql:host=".$servername.";dbname=camagru", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>