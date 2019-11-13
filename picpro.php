<?php
    $retrive = array();
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    if (isset($retrive['image'])) {
        $reimage = explode(",", $retrive['image']);
        $encodedData = str_replace(' ','+',$reimage[1]);
        $decodedData = base64_decode($encodedData);
        $fp = fopen("canvas.jpeg", 'wb');
        fwrite($fp, $decodedData);
        fclose($fp);
        $type = 'pgn';
        switch($retrive['rad']){
            case "bat":
                
                $image1 = 'canvas.jpeg';
                $image2 = './stikers/bat.png';

                list($width, $height) = getimagesize($image2);

                $image1 = imagecreatefromstring(file_get_contents($image1));
                $image2 = imagecreatefromstring(file_get_contents($image2));

                imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
                imagepng($image1, 'merge.png');

                $data = file_get_contents('merge.png');
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                include_once('./picdb.php');
                $as = new picdb();
                $as->tempsave($base64);             
                break;
            case "glass":
                $image1 = 'canvas.jpeg';
                $image2 = './stikers/glass.png';

                list($width, $height) = getimagesize($image2);

                $image1 = imagecreatefromstring(file_get_contents($image1));
                $image2 = imagecreatefromstring(file_get_contents($image2));

                imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
                imagepng($image1, 'merge.png');

                $data = file_get_contents('merge.png');
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                include_once('./picdb.php');
                $as = new picdb();
                $as->tempsave($base64);                 
                break;
            case "tree":
                $image1 = 'canvas.jpeg';
                $image2 = './stikers/tree.png';

                list($width, $height) = getimagesize($image2);

                $image1 = imagecreatefromstring(file_get_contents($image1));
                $image2 = imagecreatefromstring(file_get_contents($image2));

                imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
                imagepng($image1, 'merge.png');

                $data = file_get_contents('merge.png');
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                include_once('./picdb.php');
                $as = new picdb();
                $as->tempsave($base64);                 
                break;
            default:
                include_once('./picdb.php');
                $as = new picdb();
                $as->tempsave($retrive['image']);
        }
    }
?>