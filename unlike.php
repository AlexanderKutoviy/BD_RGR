<?php
session_start();

require_once("database.php");
require_once("models/content.php");

$link = db_connect();
$error = true;
$user = $_SESSION['login'];
$video = $_SESSION['video'];

if (isset($user) && isset($video)) {
    echo '<script type="text/javascript">alert(' . $user + $video . ');</script>';
    $error = false;
    unlike_video($link, $user, $video);
} else {
    $error = true;
}
?>