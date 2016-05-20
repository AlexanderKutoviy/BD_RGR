<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Search page </title>
    <link rel="stylesheet" href="../views/style_for_search.css">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="main.js"></script>
</head>

<body background="../content/bckg_img.png">

<div class="header">
    <img src="../content/omfg18.png">
</div>

<div class="menu" align="center">
    <div class="menu_item" align="center"><a href="../index.php">Main Page</a></div>
    <div class="menu_item" align="center"><a href="../views/user_search.php">Search</a></div>
    <div class="menu_item" align="center"><a href="index.php?action=bookmarks">Favourites</a></div>
</div>
<br>

<div><a href="index.php?action=add"> Add content </a>
    <div><a href="index.php?action=put"> Add tags </a>
        <div class="content">
            <?php for ($j = 0; $j < count($content); $j = $j + 1) { ?>
                <div class="col<?= $j ?>"><a href="../video_page.php?id=<?= $content[$j]['id'] ?>">
                        <div class="col_div1<?= $j ?>"></div>
                        <div class="col_div2<?= $j ?>"></div>
                        <div class="col_div3<?= $j ?>"></div>
                        <div class="col_div4<?= $j ?>"></div>
                        <div class="col_div5<?= $j ?>"></div>
                    </a>
                    <a href="index.php?action=edit&id=<?= $content[$j]['id'] ?>">Редактировать</a>
                    <a href="index.php?action=delete&id=<?= $content[$j]['id'] ?>">Удалить</a>
                </div>
                <style type="text/css">
                    .col<?=$j?> {
                        margin-right: 15px;
                        margin-bottom: 15px;
                        display: inline-block;
                        width: 250px;
                        height: 200px;
                        padding-left: 0px;
                        background-size: 100%;
                        /* background-size: 200px 250px;
                         background-repeat: no-repeat;
                         background-image: url("../content/ass1.jpg");*/
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
                        $(".col<?=$j?>").css('backgroundImage', 'url(../<?=$content[$j]['picture']?>)');
                        $(".col<?=$j?>").mouseenter(function () {
                            $(".col_div1<?=$j?>").mouseenter(function () {
                                $(".col<?=$j?>").css("backgroundImage", "url(../<?=$content[$j]['picture1']?>)");
                            });
                            $(".col_div2<?=$j?>").mouseenter(function () {
                                $(".col<?=$j?>").css("backgroundImage", "url(../<?=$content[$j]['picture2']?>)");
                            });
                            $(".col_div3<?=$j?>").mouseenter(function () {
                                $(".col<?=$j?>").css("backgroundImage", "url(../<?=$content[$j]['picture3']?>)");
                            });
                            $(".col_div4<?=$j?>").mouseenter(function () {
                                $(".col<?=$j?>").css("backgroundImage", "url(../<?=$content[$j]['picture4']?>)");
                            });
                            $(".col_div5<?=$j?>").mouseenter(function () {
                                $(".col<?=$j?>").css("backgroundImage", "url(../<?=$content[$j]['picture5']?>)");
                            });
                        });
                    });
                </script>
            <?php } ?>
        </div>
</body>
</html>