<?php
    include_once('./sessionmanagement.php');
    $retrive = array();
    $display = "";
    $displayhd = "";
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    if (isset($_POST['submit'])){
        $file = $_FILES['file'];

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileEror = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileAxtualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileAxtualExt, $allowed))
        {
            if ($fileEror === 0)
            {
                if ($fileSize < 1000000)
                {
                    $fileNameNew = "merge.".$fileAxtualExt;
                    $filedest = "./".$fileNameNew;
                    move_uploaded_file($fileTmpName, $filedest);
                    $display = "hidden";
                    $displayhd = "hid";
                    $data = file_get_contents('merge.'.$fileAxtualExt);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    // echo $base64;
                    // header("Location: editpic.php");

                }else{
                    echo "file too big";
                }
            }else{
                echo "there was error with upload";
            }
        }else{
            echo "can not upload file";
        }
    }
    if (isset($_POST['merge'])){
        include("editpic.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gallery</title>
</head>
<body>
    <div id="<?php echo $displayhd; ?>">
        <form action="./upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" name="submit">Upload</button>
        </form>
    </div>
    <div class="controller" id="<?php echo $display; ?>" style="display: none;">
        <form action="./upload.php" method="POST" enctype="multipart/form-data">
            <div>
                <img id="dimage"  src="<?php echo $base64; ?>"  style="width: 450px;hight: 450px;">
                bat<input type="radio" id="rad" name="rad" value="bat">
                glass<input type="radio" id="rad" name="rad" value="glass">
                tree<input type="radio" id="rad" name="rad" value="tree">
                <!-- <input type="hidden" value="<?php echo $base64; ?>" name="dimage"> -->
                <button type="submit" name="merge">Upload</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById("hidden").style.display = "initial";
        document.getElementById("hid").style.display = "none";
    </script>
     <a href="logout.php">logout</a>
</body>
</html>