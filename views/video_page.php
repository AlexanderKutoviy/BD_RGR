<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Video page </title>
    <link rel="stylesheet" href="views/style_for_video.css">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <!-- <script type="text/javascript" src="ajax.js"></script> -->

<body background="content/bckg_img.png">
<?php error_reporting(E_ERROR); ?>

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

<div class="center">
    <video id="video1" controls preload> <!--16/9-->
        <source src="<?= $post['video_url'] ?>" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <?php
    $_SESSION['video'] = $post['video_url'];
    ?>
    <script>
        var v = document.getElementById("video1");
        v.onclick = function () {
            if (v.paused) {
                v.play();
            } else {
                v.pause();
            }
        };
    </script>
    <br><br>
    <div id="like">
    </div>
    <span></span>
    <br>
    <?php
    //-------------------------------------------------------------------CHECK IF VIDEO IS LIKED
    for ($i = 0; $i < count($likes); $i++) {
        if (strcmp($post['video_id'], $likes[$i]["video_id"]) == 0) {
            $count = 1;
            break;
        } else {
            $count = 0;
        }
    }
    if ($count == 0) {
        ?>
        <script>
            $(document).ready(function () {
                $("#like").css("backgroundImage", "url(content/like_button.png)");
                $("#like").bind("click", function (event) {
                    $("#like").css("backgroundImage", "url(content/like_button_yes.png)");
                    var video = "<?=$_SESSION['video']?>";
                    var login = "<?=$_SESSION['login']?>";
                    $.ajax({
                        url: "like.php",
                        type: "POST",
                        data: ("video=" + video),
                        dataType: "text",
                        success: function (result) {
                            if (!result.error) {
                                //alert(login+ " -->> "+ video);
                            }
                            else alert("Error");
                        }
                    });
                });
            });
        </script>
    <?php }
    if ($count == 1) { ?>
        <script>
            $(document).ready(function () {
                $("#like").css("backgroundImage", "url(content/like_button_yes.png)");
                $("#like").bind("click", function (event) {
                    $("#like").css("backgroundImage", "url(content/like_button.png)");
                    var video = "<?=$_SESSION['video']?>";
                    var login = "<?=$_SESSION['login']?>";
                    $.ajax({
                        url: "unlike.php",
                        type: "POST",
                        data: ("video=" + video),
                        dataType: "text",
                        success: function (result) {
                            if (!result.error) {
                                //alert(login+ " -->> "+ video);
                            }
                            else alert("Error");
                        }
                    });
                });
            });
        </script>
    <?php } ?>
<br>
    <div class="tags">
        <?php
        $tTags = explode(",",$post['GROUP_CONCAT(Tags.tag)']);
        for ($i = 0; $i < count($tTags); $i++) {
            ?>
            <div class="nonchosen_tag"><?= $tTags[$i] ?></div>
            <?php
        }
        ?>
    </div>
    <br>
    <div class="separator"></div>
    <br>
    <div class="description"><?= $post['description'] ?></div>
</div>
</body>
</html>