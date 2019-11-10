<?php
        echo "<div class='nev'>";
        echo "<div class='nevlink'>";
        echo "<div><h2 class='nev_h'>Gallery</h2></div>";
        if ($_SESSION["userid"])
        {
            echo '<a href="gallery.php" class = "nev_a">Profile</a> ';
            echo '<a href="logout.php" class = "nev_a">logout</a>';
        }else
        {
            echo '<a href="login.php" class= "nev_a">login</a> ';
            echo '<a href="register.php" class = "nev_a">Register</a>';
        }
        echo "</div>";
        echo "</div>";
?>