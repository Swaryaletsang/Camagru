<?php
    session_start();

    if (isset($_POST['submit'])) {
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
    
?> 
<html>
    <body>
        <a href="modify.php">Edit Profile</a>
        <div>
            <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" id="image">
            <button type="submit" name="submit">Upload</button>
            </form>
        </div>
    </body>    
</html>