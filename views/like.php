<?php
session_start();
require_once("database.php");
require_once("models/content.php");
$link = db_connect();
$error = true;
$user = strval($_POST['login']);
$video = strval($_POST['video']);
if (isset($user) && isset($video)) {
    $error = false;
    print_r($_POST);
    likeVideo($link, $user, $video);
} else {
    $error = true;
    echo json_encode($error);
}
?>