<?php

    session_start();
    
    include_once('picpro.php');
    if (!$_SESSION['userid'])
        header('Location: login.php');
    if (isset($_POST['ims']))
    {
        include('savimg.php');
        $ar = new saveimg();
        $ar->saveimg($_POST['ims'], $_SESSION['userid']);
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
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header.css">
    <title>Edit</title>
 
</head>
<body>
    <div style="width:100%;">
    <?php
    include("./navigation/desp.php");
    include("./navigation/nev_cam.php");
    ?>
    <br>
    <div style= "width: 100%; height: auto;">

        <div style="float: left; margin-left: 20%; heigt: auto; width: 40%;">
            <form action="cam.php" method="post">
                <div class="video-wrap" >
                    <video id="video" playsinline autoplay style="width: 100%; max-height: 100%;"></video>
                </div>
    
                    <input type="hidden" value="" id="image" name="image">
                <div style="width:100%; max-width:500px;">
                    <button id="snap" type="submit">Capture</button>
                    bat<input type="radio" id="rad" name="rad" value="bat">
                    glass<input type="radio" id="rad" name="rad" value="glass">
                    tree<input type="radio" id="rad" name="rad" value="tree">
                </div>
    
                <canvas id="canvas" width="450" height="450" style="float:left; width: 100%; max-height: 100%;"></canvas>
            </form>
        </div>
        <div style="float: right; width: 35%; hight: auto;">
            <form action="cam.php" method="post">
            <?php
                include_once('./picdb.php');
                $arr = new picdb();
                $display = $arr->getsave();
                $i = 0;
                while($i < count($display))
                {
                    echo '<button id="s" name="ims" value="'.$display[$i]['images'].'"><img src="'.$display[$i]['images'].'" style="width: 30%; hight: auto; margin:0%" ></button>';
                    $i++;
                } 
            ?>
            </form>
            <button id="save" style="display: none;">Save</button>
        </div>
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
                    width: 450, height: 450
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
        </div>
        <div style="margin-top: 100%;">
        <?php
            include ('./footer/footer.php'); 
        ?>
        </div>
</body>
</html>