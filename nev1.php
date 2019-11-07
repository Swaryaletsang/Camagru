<?php
        if ($_SESSION["userid"])
        {
            echo '<a href="gallery.php">Profile</a> ';
            echo '<a href="logout.php">logout</a>';
        }else
        {
            echo '<a href="login.php">login</a> ';
            echo '<a href="register.php">Register</a>';
        }
?>