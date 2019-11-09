<?php
        include("val.php");
       $va = new va();
       $id = $va->get_user($_SESSION['userid']);
       if ($_SESSION['userid']){
           echo "<div class = 'nev'>";
                echo "<div id = user>";
                    echo 'You are logged in as ' .$id[0]['username'] .'<br>';
                echo "</div>";
            echo "</div>";
       } 
           

?>