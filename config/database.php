<?php

$servername = "localhost";
$username = "root";
$password = "qwerty";

$count = 0;

try {
   $conn = new PDO("mysql:host=".$servername, $username, $password);
   // set the PDO error mode to exception
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $sql = "CREATE DATABASE IF NOT EXISTS camagru";
   $conn->exec($sql);
   $count = 1;
}
catch(PDOException $e)
{
   $ret = "Connection failed: " . $e->getMessage();
}
?>