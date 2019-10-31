<?php
        switch($retrive['rad']){
            case "bat":
                $list = scandir('./');
                $i = 0;
                while($i < count($list))
                {
                    if (preg_match('/merge\.[A-Za-z]{3,}/', $list[$i]))
                        $image1 = $list[$i];
                    $i++;
                }
                $image2 = 'bat.png';

                list($width, $height) = getimagesize($image2);

                $image1 = imagecreatefromstring(file_get_contents($image1));
                $image2 = imagecreatefromstring(file_get_contents($image2));

                imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
                imagepng($image1, 'merge.png');

                $data = file_get_contents('merge.png');
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                include('savimg.php');
                $ar = new saveimg();
                $ar->saveimg($base64, $_SESSION['username']);
                $s = shell_exec('rm merge.png');
                header("Location: gallery.php");             
                break;
            case "glass":
                $list = scandir('./');
                $i = 0;
                while($i < count($list))
                {
                    if (preg_match('/merge\.[A-Za-z]{3,}/', $list[$i]))
                        $image1 = $list[$i];
                    $i++;
                }
                $image2 = 'glass2.png';

                list($width, $height) = getimagesize($image2);

                $image1 = imagecreatefromstring(file_get_contents($image1));
                $image2 = imagecreatefromstring(file_get_contents($image2));

                imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
                imagepng($image1, 'merge.png');

                $data = file_get_contents('merge.png');
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                include('savimg.php');
                $ar = new saveimg();
                $ar->saveimg($base64, $_SESSION['username']);
                $s = shell_exec('rm merge.png');
                header("Location: gallery.php");                
                break;
            case "tree":
                $list = scandir('./');
                $i = 0;
                while($i < count($list))
                {
                    if (preg_match('/merge\.[A-Za-z]{3,}/', $list[$i]))
                        $image1 = $list[$i];
                    $i++;
                }                
                $image2 = 'tree.png';

                list($width, $height) = getimagesize($image2);

                $image1 = imagecreatefromstring(file_get_contents($image1));
                $image2 = imagecreatefromstring(file_get_contents($image2));

                imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
                imagepng($image1, 'merge.png');

                $data = file_get_contents('merge.png');
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                include('savimg.php');
                $ar = new saveimg();
                $ar->saveimg($base64, $_SESSION['username']);
                $s = shell_exec('rm merge.png');
                header("Location: gallery.php");                 
                break;
            default:
                $list = scandir('./');
                $i = 0;
                while($i < count($list))
                {
                    if (preg_match('/merge\.[A-Za-z]{3,}/', $list[$i]))
                        $image1 = $list[$i];
                    $i++;
                } 
                $data = file_get_contents($image1);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                include('savimg.php');
                $ar = new saveimg();
                $ar->saveimg($base64, $_SESSION['username']);
                $s = shell_exec('rm merge.png');
                header("Location: gallery.php");
        }
?>