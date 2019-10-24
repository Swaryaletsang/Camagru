<?php

    session_start();
    include('./val.php');
    echo "welcome you beatuify thing!!!!!!!!!!";
    $va = new va();
    $id = $va->get_user( $_SESSION['userid']);
    print_r($id); 
   //echo $_SESSION['userid'] ;
    // $a = get_uid($_SESSION['userid']);
    // print_r($a);
   
?> 
<html>
    <body>
        <a href="modify.php">Edit Profile</a>
    </body>    
</html>