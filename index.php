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

if ($action == "search") {
    $content = searchViaTags($link, $_POST['tags']);
} else if ($action == "bookmarks") {
    $content = getLikedVideos($link, $_SESSION['login']);
    if (!isset($content)) {
        echo "У вас еще нет любимых записей";
    }
} else {
    $content = getAllContent($link);
}
include("views/search_page.php");
?>