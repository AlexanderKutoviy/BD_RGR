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
    echo implode("+", $_POST['tags']);
    $content = search_all($link, $_POST['tags']);
} else if ($action == "bookmarks") {
    $content = search_name($link, $_SESSION['login']);
    if (!isset($content)) {
        echo "У вас еще нет любимых записей";
    }
} else {
    $content = post_all($link);
}
include("views/search_page.php");
?>