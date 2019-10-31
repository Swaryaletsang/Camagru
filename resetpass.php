<?php
   include("./userauth.php");
   $retrive = array();
   foreach($_POST as $key => $value)
      $retrive[$key] = $value;

   if ($retrive["password"] && $retrive["re-password"]) {
      $aa = new userauth();
      if ($aa->updatepass($retrive['password'], $retrive['userid'], $retrive['re-password']))
      {
          header('location: login.php');
      }else
      {
         header("location: forgotpass.php");
      }
   }else
   {
      header("location: forgotpass.php");
   }
?>