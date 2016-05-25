<?php
session_start();
require_once("database.php");
require_once("models/content.php");
$link = db_connect();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}
$post = getOnePost($link, $_GET['id']);
$likes = getLikedVideos($link, $_SESSION['login']);
error_reporting(E_ERROR);
include("views/video_page.php");
?>