<?php
// $srcImg = imagecreatefrompng('ballons.png');
// $destImg = imagecreatefrompng('canvas.ping');
// if (imagecopymerge($destImg, $srcImg, 0, 0, 0, 0, 640, 480, 100))
// {
//     header('Content-Type: image/png');
//     imagepng($destImg, 'meg.png');
// }
// imagedestroy($destImg);
// imagedestroy($srcImg);

// $im1 = imagecreatefrompng('/goinfre/pmogwere/Desktop/MAP/apache2/htdocs/camagru/canvas.png');
// $im2 = imagecreatefrompng('/goinfre/pmogwere/Desktop/MAP/apache2/htdocs/camagru/balloons.png');

// imagecopyresampled($im1,$im2,250,150,0,0,100,150,100,150);
// unset($im2);

$image1 = 'canvas.jpeg';
$image2 = 'tree.png';

list($width, $height) = getimagesize($image2);

$image1 = imagecreatefromstring(file_get_contents($image1));
$image2 = imagecreatefromstring(file_get_contents($image2));

imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
header('Content-Type: image/png');
imagepng($image1);
?>