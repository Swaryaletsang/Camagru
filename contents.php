<?php
    session_start();

    if (isset($_POST['submit'])) {
        $file = $_FILES['image'];
        $fileMame = $file['name'];
    } else {
        # code...
    }
    
?> 
<html>
    <body>
        <a href="modify.php">Edit Profile</a>
        <div>
            <form action="" method="POST" enctype="multipart/form-data"></form>
            <input type="file" name="image" id="image">
            <button type="submit" name="submit">Upload</button>
        </div>
    </body>    
</html>