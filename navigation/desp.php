<?php
        include("val.php");
       $va = new va();
       $id = $va->get_username($_SESSION['userid']);
       if ($_SESSION['userid']){
           echo '<div class = "nev">';
                echo '<div class = "user">';
                    echo 'You are logged in as ' .$id[0]['username'] .'<br>';
                echo "</div>";
            echo "</div>";
       } 
           

?>