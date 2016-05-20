<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> OMFG 18+ </title>
    <link rel="stylesheet" href="views/style_for_search.css">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="main.js"></script>
</head>
<body background="content/bckg_img.png">
<div class="header">
    <div class="logo"><a href="index.php"><img src="content/omfg18.png"></a></div>
</div>
<div class="menu" align="center">
    <a href="index.php">
        <div class="menu_item" align="center">Main Page</div>
    </a>
    <a href="views/user_search.php">
        <div class="menu_item" align="center">Search</div>
    </a>
    <?php if (!empty($_SESSION['login'])) { ?>
        <a href="index.php?action=bookmarks">
            <div class="menu_item" align="center">Favourites</div>
        </a>
        <a href='login/exit.php'>
            <div class="menu_item" align="center">Exit</div>
        </a>
    <?php } else { ?>
        <a href="login/reg.php">
            <div class="login_butt"></div>
        </a>
    <?php } ?>
</div>
<br>
<?php
// Проверяем, пусты ли переменные логина и id пользователя
if (empty($_SESSION['login']) or empty($_SESSION['id'])) {

    // Если пусты, то мы не выводим ссылку
    //echo "Вы вошли на сайт, как гость";
} else {
    // Если не пусты, то мы выводим ссылку
    // echo "Вы вошли на сайт, как ".$_SESSION['login'];
    if ($_SESSION['login'] == 'admin') {
        ?>
        <br><a href="admin"> Admin panel</a>
    <?php } ?>
    <?php
}
?>
<div class="content">
    <?php for ($j = 0; $j < count($content); $j = $j + 1) { ?>
        <div class="col_wrapper">
            <div class="col<?= $j ?>"><a href="video_page.php?id=<?= $content[$j]['id'] ?>">
                    <div class="col_div1<?= $j ?>"></div>
                    <div class="col_div2<?= $j ?>"></div>
                    <div class="col_div3<?= $j ?>"></div>
                    <div class="col_div4<?= $j ?>"></div>
                    <div class="col_div5<?= $j ?>"></div>
                </a>
            </div>
        </div>
        <style type="text/css">
            .col<?=$j?> {
                margin: auto;
                width: 250px;
                height: 200px;
                padding-left: 0px;
                display: inline-block;
                background-size: 100%;
            }

            .col_div1<?=$j?> {
                margin-left: 5px;
                margin-top: 5px;
                width: 45px;
                height: 190px;
                display: inline-block;
            }

            .col_div2<?=$j?> {
                margin-top: 5px;
                width: 45px;
                height: 190px;
                display: inline-block;
            }

            .col_div3<?=$j?> {
                margin-top: 5px;
                width: 45px;
                height: 190px;
                display: inline-block;
            }

            .col_div4<?=$j?> {
                margin-top: 5px;
                width: 45px;
                height: 190px;
                display: inline-block;
            }

            .col_div5<?=$j?> {
                margin-top: 5px;
                width: 45px;
                height: 190px;
                display: inline-block;
            }

            .col<?=$j?> img {
                width: 250px;
                height: 200px;
            }

            .col<?=$j?> :hover img {
                visibility: hidden;
            }

            .col<?=$j?> a {
                display: block;
            }
        </style>
        <script>
            $(document).ready(function () {
                $(".col<?=$j?>").css('backgroundImage', 'url(<?=$content[$j]['picture']?>)');
                $(".col<?=$j?>").mouseenter(function () {
                    $(".col_div1<?=$j?>").mouseenter(function () {
                        $(".col<?=$j?>").css("backgroundImage", "url(<?=$content[$j]['picture1']?>)");
                    });
                    $(".col_div2<?=$j?>").mouseenter(function () {
                        $(".col<?=$j?>").css("backgroundImage", "url(<?=$content[$j]['picture2']?>)");
                    });
                    $(".col_div3<?=$j?>").mouseenter(function () {
                        $(".col<?=$j?>").css("backgroundImage", "url(<?=$content[$j]['picture3']?>)");
                    });
                    $(".col_div4<?=$j?>").mouseenter(function () {
                        $(".col<?=$j?>").css("backgroundImage", "url(<?=$content[$j]['picture4']?>)");
                    });
                    $(".col_div5<?=$j?>").mouseenter(function () {
                        $(".col<?=$j?>").css("backgroundImage", "url(<?=$content[$j]['picture5']?>)");
                    });
                });
            });
        </script>
    <?php } ?>
</div>
</body>
</html>