<?php
    error_reporting(0);
    session_start();
    include('./usermngt.php');
    include('./val.php');

    $va = new va();
    $id = $va->get_user($_SESSION['userid']);
    if ($_SESSION['userid']){

        if (isset($_POST['submit'])) {
            $uid = $id[0]['userid'];
            $file = $_FILES['image'];

            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            //  --------------------
            include "savimg.php";
            $file_name = $_FILES['image']['name'];
        $balls = explode('.',$file_name);
            $file_ext = strtolower( end($balls));

            $file_tmp= $_FILES['image']['tmp_name'];

            $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
            $data = file_get_contents($file_tmp);
            $base64 = 'data:image/' . $file_ext . ';base64,' . base64_encode($data);
            
            // ---------------------

            $allowed = array('jpg', 'jpeg', 'gif', 'png', 'tif');
            if (in_array($file_ext, $allowed)){
                if ($fileError === 0){
                    if ($fileSize < 500000) {
                        //prevents deletio of images that has similar name
                        $imageNameNew = uniqid('', true).".".$fileActualExt;
                        $imageDestination = './uploads/'.$imageNameNew;
                        move_uploaded_file($fileTmpName, $imageDestination);
                        $sav = new saveimg();$sav->saveimg($base64, $uid);
                        header("Location: gallery.php");
                    }else {
                        echo "Your file is too big!";
                    }
                }else{
                    echo "There was an error uploading your Image";
                }
            }
            elseif (!$_FILES['image']['name']){
                echo "Nothing To Upload";
            }
            else{
                echo "You cannot upload files of this type!";
            }
        }
}else {
    header("Location: login.php");
}

// if(isset($_POST['submitdelete']))
// {
//     $var = new images();
//     $uid = $id[0]['userid'];
//     $pid = $_POST['submitdelete'];
//     $var->deletepost($uid ,$pid);
// }
    
?> 
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
    <body>
    <header>
    <h1 class="logo">INSTAGRU</h1>
    <nav class="nav_links">
        <ul>
            <li><a href="logout.php">logout</a></li>
            <li><a href="contents.php">upload</a></li>
            <li><a href="modify.php">edituser</a></li>
            <li><a href="index.php">public</a> </li> 
        </ul>
</nav>
    </header>
    <?php
    if ($_SESSION['userid']){
        // echo  "<a href='modify.php'>Edit Profile</a><br>";
        // echo  "<a href='cam.php'>Take a picture</a><br>";
        echo "<form action='logout.php' method='POST'>
            <button type='submit' name='logoutsubmit' id='logoutsubmit'>Logout</button>
        </form>";
    }
    ?>
        <div>
           <?php

            if ($_SESSION['userid']){
            echo "<form action='' method='POST' enctype='multipart/form-data'>
            <input type='file' name='image' id='image'>
            <button type='submit' name='submit'>Upload</button>
            </form>";
            }
            ?> 
        </div>
        <!-- <?php
        $va = new va();
        $id = $va->get_user($_SESSION['userid']);
        $var = new images();
        $r = $var->displayImage($id[0]['userid']);
            foreach($r as $row){
                echo "<div id='img'>";
                    echo "<img src='uploads/".$row['images']."'>";
                    echo "<p>".$row['txt']."</p>";
                   echo " <form action='contents.php' method= 'POST'>
                    <button class='button' type='submit' name='submitdelete' value='".$row['id']."'>Delete</button>
                </form>";             
                echo "</div>";
            }
        ?> -->
    

    </body>    
</html>