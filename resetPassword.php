<?php
    include("connection.php");
    include("usermngt.php");
    include("val.php");
    $vkey2 = $_GET['vkey'];
    $val = new va();
    if ($val->updatekey($vkey2)){
        // $sql = 'UPDATE TABLE users SET vkey = null';
        // $stmt = $conn->prepare($sql);
        // //$stmt->bindParam(":vkey", $vkey2);
        // $stmt->execute();
        header("location: updatePassword.php");
    }
?>