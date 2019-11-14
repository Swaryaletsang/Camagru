<?php
error_reporting(0);
    session_start();
    include_once('val.php');
    include_once('picpro.php');
    if (!$_SESSION['userid'])
        header('Location: login.php');
    $bar = new va;
    $id = $bar->get_user($_SESSION['userid']);
    $uid = $id[0]['userid'];
    if ($_POST['ims'])
    {
        include('savimg.php');
        $ar = new saveimg();
        $ar->saveimg($_POST['ims'], $uid);
        $s = shell_exec('rm merge.png');
        $s = shell_exec('rm canvas.jpeg');
        header("Location: gallery.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
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
    <div style="float: left; margin-left: 500px;">
        <form action="cam.php" method="post">
            <div class="video-wrap" >
                <video id="video" playsinline autoplay style="margin-left:0;"></video>
            </div>

                <input type="hidden" value="" id="image" name="image">
            <div class="controller">
                <button id="snap" type="submit">Capture</button>
                bat<input type="radio" id="rad" name="rad" value="bat">
                glass<input type="radio" id="rad" name="rad" value="glass">
                tree<input type="radio" id="rad" name="rad" value="tree">
            </div>

            <canvas id="canvas" width="450" height="450" style="float:left; display: none"></canvas>
        </form>
    </div>
    <div style="float: right; width: 400px; hight: auto;">
        <form action="cam.php" method="post">
        <?php
            include_once('./picdb.php');
            $arr = new picdb();
            $display = $arr->getsave();
            $i = 0;
            while($i < count($display))
            {
                echo '<button id="s" name="ims" value="'.$display[$i]['images'].'"><img src="'.$display[$i]['images'].'" style="width: 100px; margin-left:6px; height: 100px;" ></button>';
                $i++;
            } 
        ?>
        </form>
    </div>

    <div>
        <button id="save" style="display: none;">Save</button>
    </div>
    <script>
            'use strict';
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const snap = document.getElementById('snap');
            const image = document.getElementById("image");
            const errorMsgElement = document.getElementById('span#ErrorMsg');
            const constraints = {
                video:{
                    width: 400, height: 400
                }
            };
            async function init()
            {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    handleSuccess(stream);
                } catch (e) {
                    errorMsgElement.innerHTML = 'navigator.getUserMedia.error:${e.toString()}';
                }
            }
            function handleSuccess(stream){
                window.stream = stream;
                video.srcObject = stream;
            }
            init();
            var context = canvas.getContext('2d');
            snap.addEventListener("click", function(){
                context.drawImage(video, 0, 0, 450, 450);
                const dataURI = canvas.toDataURL();
                image.setAttribute('value', dataURI);

            });

        </script>
</body>
</html>