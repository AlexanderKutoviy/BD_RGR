<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
    <link rel="stylesheet" type="text/css" href="styleForSearch.css"/>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="search.js"></script>
</head>
<body background="../content/bckg_img.png">
<div class="header">
    <div class="logo"><a href="../index.php"><img src="../content/omfg18.png"></a></div>
</div>
<?php
session_start();
require_once("../database.php");
require_once("../models/content.php");
$link = db_connect();
$tags = post_tags($link);
?>
<div class="menu" align="center">
    <a href="../index.php">
        <div class="menu_item" align="center">Main Page</div>
    </a>
    <a href="user_search.php">
        <div class="menu_item" align="center">Search</div>
    </a>
    <?php if (!empty($_SESSION['login'])) { ?>
        <a href="../index.php?action=bookmarks">
            <div class="menu_item" align="center">Favourites</div>
        </a>
        <a href='../login/exit.php'>
            <div class="menu_item" align="center">Exit</div>
        </a>
    <?php } else { ?>
        <a href="../login/reg.php">
            <div class="login_butt"></div>
        </a>
    <?php } ?>
</div>
<form method="post" action="../index.php?action=search">
    <div class="wrapper">
        <div class="tags">
            <div class="instruction">Popular Tags :</div>
            <br>
            <?php
            for ($i = 0; $i < 5; $i++) {
                ?>
                <input type="checkbox" name="tags[<?= $i ?>]" id="tag<?= $i ?>" class="hide-checkbox"
                       value="<?= $tags[$i]["tag"] ?>">
                <label for="tag<?= $i ?>"><?= $tags[$i]["tag"] ?></label>
            <?php } ?>
            <br>
            <br>
            <br>
            <div class="separator"></div>
            <br>
            <div class="instruction">All Tags :</div>
            <br>
            <?php
            for ($i = 5; $i < count($tags); $i++) {
                ?>
                <input type="checkbox" name="tags[<?= $i ?>]" id="tag<?= $i ?>" class="hide-checkbox"
                       value="<?= $tags[$i]["tag"] ?>">
                <label for="tag<?= $i ?>"><?= $tags[$i]["tag"] ?></label>
            <?php } ?>
        </div>
        <div class="getit">
            <input type="submit" value="Search" id="get_button">
            <label for="get_button">
                <div class="button" align="center">
                    Search
                </div>
            </label>
            </input>
        </div>
    </div>
</form>
</body>
</html>