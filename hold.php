<header>
        <h1 class="logo">INSTAGRU</h1>
    <nav class="nav_links">
        <?php
            if ($_SESSION["userid"])
            {
                echo '<ul><li><a href="gallery.php">Profile</a></li> 
                        <li><a href="logout.php">logout</a></li></ul>';
            }else
            {
                echo '<ul><li><a href="login.php">login</a></li> ';
                echo '<li><a href="register.php">Register</a></li><ul>';
            }
        ?>
    </nav>