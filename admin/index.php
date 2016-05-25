<?php
require_once("../database.php");
require_once("../models/content.php");

$link = db_connect();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}

if ($action == "add") {//_______________________________________________________________________________________________ ADD
    $tags_base = post_tags($link);
    if (!empty($_POST)) {
        $b1 = move($_FILES['video']['name'], $_FILES['video']['tmp_name']);
        $b2 = move($_FILES['picture']['name'], $_FILES['picture']['tmp_name']);
        $b3 = move($_FILES['picture1']['name'], $_FILES['picture1']['tmp_name']);
        $b4 = move($_FILES['picture2']['name'], $_FILES['picture2']['tmp_name']);
        $b5 = move($_FILES['picture3']['name'], $_FILES['picture3']['tmp_name']);
        $b6 = move($_FILES['picture4']['name'], $_FILES['picture4']['tmp_name']);
        $b7 = move($_FILES['picture5']['name'], $_FILES['picture5']['tmp_name']);

        if ($b1 && $b2 && $b3 && $b4 && $b5 && $b6 && $b7) {
            addContent($link,
                $_POST['title'],
                $_FILES['video']['name'],
                $_FILES['picture']['name'],
                $_POST['description'],
                $_POST['tags'],
                $_FILES['picture1']['name'],
                $_FILES['picture2']['name'],
                $_FILES['picture3']['name'],
                $_FILES['picture4']['name'],
                $_FILES['picture5']['name']);
        }
        header("Location:index.php");
    }
    include("../views/admin_add.php");

} else if ($action == "edit") {//_______________________________________________________________________________________ EDIT
    if (!isset($_GET['id']))
        header("Location: index.php");
    $id = (int)$_GET['id'];
    if (!empty($_POST) && $id > 0) {
        $b1 = move($_FILES['video']['name'], $_FILES['video']['tmp_name']);
        $b2 = move($_FILES['picture']['name'], $_FILES['picture']['tmp_name']);
        $b3 = move($_FILES['picture1']['name'], $_FILES['picture1']['tmp_name']);
        $b4 = move($_FILES['picture2']['name'], $_FILES['picture2']['tmp_name']);
        $b5 = move($_FILES['picture3']['name'], $_FILES['picture3']['tmp_name']);
        $b6 = move($_FILES['picture4']['name'], $_FILES['picture4']['tmp_name']);
        $b7 = move($_FILES['picture5']['name'], $_FILES['picture5']['tmp_name']);

        if ($b1 && $b2 && $b3 && $b4 && $b5 && $b6 && $b7) {
            editPost($link,
                $id,
                $_POST['title'],
                $_FILES['video']['name'],
                $_FILES['picture']['name'],
                $_POST['description'],
                $_POST['tags'],
                $_FILES['picture1']['name'],
                $_FILES['picture2']['name'],
                $_FILES['picture3']['name'],
                $_FILES['picture4']['name'],
                $_FILES['picture5']['name']);
        }
        header("Location: index.php");
    }

    $post = getOnePost($link, $id);
    include("../views/admin_add.php");

} else if ($action == "delete") {//_____________________________________________________________________________________ DELETE
    $id = $_GET['id'];
    $post = getOnePost($link, $_GET['id']);
    deleteFile('C:/xampp/htdocs/cakes_site/' . $post['video']);
    $post = deletePost($link, $id);
    header("Location:index.php");
} else if ($action == "put") {//________________________________________________________________________________________ PUT
    if (!empty($_POST)) {
        putTags($link, $_POST['tags']);
        header("Location:index.php");
    }
    include("../views/add_tags.php");
} else {//______________________________________________________________________________________________________________ MAIN
    $content = getAllContent($link);
    include("../views/admin_search.php");
}
?>