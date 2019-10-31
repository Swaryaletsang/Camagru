<?php
    include_once('./sessionmanagement.php');
    session_destroy();
    header('Location: login.php');
?>