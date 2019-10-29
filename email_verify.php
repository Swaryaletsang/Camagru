<?php
    include("connection.php");
    include("usermngt.php");
    include("val.php");
    $vkey2 = $_GET['vkey'];
    $val = new va();
    if ($val->updatekey($vkey2))
        header("location: login.php");
?>