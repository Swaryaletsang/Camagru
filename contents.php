<?php
    //remove when doe or before marking
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    session_start();
    include('./usermngt.php');
    include('./val.php');

    $va = new va();
    $id = $va->get_user($_SESSION['userid']);

    if ($_SESSION['userid']){ 
        echo 'You are logged in as ' .$id[0]['username'] .'<br>';

        if (isset($_POST['submit'])) {
            $txt = $_POST['text'];
            $uid = $id[0]['userid'];
            $file = $_FILES['image'];

            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg', 'jpeg', 'gif', 'png', 'tif');
            if (in_array($fileActualExt, $allowed)){
                if ($fileError === 0){
                    if ($fileSize < 500000) {
                        //prevents deletio of images that has similar name
                        $imageNameNew = uniqid('', true).".".$fileActualExt;
                        $imageDestination = './uploads/'.$imageNameNew;
                        move_uploaded_file($fileTmpName, $imageDestination);
                        $var = new images();
                        $var->tbphotos();
                        $var->uploadImg($uid, $imageNameNew, $txt);
                        header("Location: contents.php?UploadSuccess");
                    }else {
                        echo "Your file is too big!";
                    }
                }else{
                    echo "There was an error uploading your Image";
                }
            }
            else{
                echo "You cannot upload files of this type!";
            }
        }
}else {
    echo 'You are not Logged in! '."<a href='Login.php'>login here</a><br>";
}

if(isset($_POST['submitdelete']))
{
    $var = new images();
    $uid = $id[0]['userid'];
    $pid = $_POST['submitdelete'];
    $var->deletepost($uid ,$pid);
}
    
?> 
<html>
    <body>
    <?php
    if ($_SESSION['userid']){
        echo  "<a href='modify.php'>Edit Profile</a><br>";
    
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
            <div>
                 <textarea name='text' cols='20' rows='3' placeholder='say something about this image...'></textarea>
            </div>
            <button type='submit' name='submit'>Upload</button>
            </form>";
            }
            ?> 
        </div>
        <?php
        $va = new va();
        $id = $va->get_user($_SESSION['userid']);
        $var = new images();
        $r = $var->displayImage($id[0]['userid']);
            foreach($r as $row){
                echo "<div id='img'>";
                    echo "<img src='uploads/".$row['img']."'>";
                    echo "<p>".$row['txt']."</p>";
                   echo " <form action='contents.php' method= 'POST'>
                    <button class='button' type='submit' name='submitdelete' value='".$row['id']."'>Delete</button>
                </form>";             
                echo "</div>";
            }
        ?>
    

    </body>    
</html>