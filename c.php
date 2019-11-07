<?php
    include("connection.php");
    $ccc = New dbhandler();
    $ccc->connect();

    $ccc->create_table();
    // SELECT `users`.`username`, `userimage`.`images`, `photos`.`images` FROM `users` INNER JOIN `userimage` ON `users`.`userid` = `userimage`.`userid` INNER JOIN `photos` ON `userimage`.`num` = `photos`.`imgid`

    // SELECT userimage.images, userimage.timess As time FROM userimage where userimage.userid = 8 UNION SELECT photos.images, photos.imgDate As time FROM photos where photos.userid = 8 ORDER BY time

?>