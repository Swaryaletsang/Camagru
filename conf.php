<?php
    // session_start();
    // if (!isset($_SESSION["username"]))
    //     header("location: ./login.php");

    include("./userauth.php");
    $retrive = array();
    $cc = "";
    foreach($_GET as $key => $value)
       $retrive[$key] = $value;
    if ($retrive["selec"]) {
       $aa = new userauth();
       if ($aa->checkemail($retrive['selec']))
       {
          header('location: login.php');
       }else{
           echo "Auth field please press this link to reset you paasword again";
       }
    }else{
       header('location: login.php');
    }
?>