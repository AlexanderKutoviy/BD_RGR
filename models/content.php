<?php

function post_all($link)
{
    //ЗАПРОС-----------------------------------------------------------------------------------
    $query = "SELECT * FROM test ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    //ИЗВЛЕЧЕНИЕ ИЗ БД-------------------------------------------------------------------------
    $n = mysqli_num_rows($result);
    $articles = array();
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $content[] = $row;
    }
    return $content;
}

function search_all($link, $tmp)
{
    $str = implode("+", $tmp);
    $sArr = explode("+", $str);
    $query = "SELECT * FROM test ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $n = mysqli_num_rows($result);
    $articles = array();
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $tags = explode("+", $row['tags']);
        $count = 0;
        for ($j = 0; $j < count($sArr); $j++) {
            for ($a = 0; $a < count($tags); $a++) {
                if (strcasecmp($sArr[$j], $tags[$a]) == 0) {
                    $count++;
                }
            }
        }
        if ($count == count($sArr))
            $content[] = $row;;
    }
    return $content;
}

function search_name($link, $login)
{
    $query1 = sprintf("SELECT * FROM users WHERE login='%s'", $login);
    $result1 = mysqli_query($link, $query1);
    if (!$result1)
        die(mysqli_error($link));
    $res = mysqli_fetch_assoc($result1);
    $users = explode(" ", $res["liked"]);
    for ($a = 0; $a < count($users); $a++) {
        $input[] = $users[$a];
    }
    unset($users);
    $query = "SELECT * FROM test ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    //ИЗВЛЕЧЕНИЕ ИЗ БД-------------------------------------------------------------------------
    $n = mysqli_num_rows($result);
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $cont[] = $row;
        $count = 0;
        for ($j = 0; $j < count($cont); $j++) {
            for ($a = 0; $a < count($input); $a++) {
                if (strcasecmp($cont[$i]['video'], $input[$a]) == 0) {
                    $count++;
                }
            }
        }
        if ($count == count($cont))
            $content[] = $row;;
    }
    return $content;
}

function post_get($link, $id_article)
{
    $query = sprintf("SELECT * FROM test WHERE id=%d", (int)$id_article);
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $post = mysqli_fetch_assoc($result);
    return $post;
}

function post_new($link,
                  $title,
                  $video,
                  $picture,
                  $description,
                  $aTags,
                  $picture1,
                  $picture2,
                  $picture3,
                  $picture4,
                  $picture5)
{
    //PREPARE
    $title = trim($title);
    $description = trim($description);
    $tags = implode("+", $aTags);;
    //CHECK
    if ($title == '')
        return false;
    //QUERY
    $t = "INSERT INTO test (title, video, picture, description, tags, picture1, picture2, picture3, picture4, picture5) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    $query = sprintf($t,
        mysqli_real_escape_string($link, $title),
        "content/" . mysqli_real_escape_string($link, $video),
        "content/" . mysqli_real_escape_string($link, $picture),
        mysqli_real_escape_string($link, $description),
        mysqli_real_escape_string($link, $tags),
        "content/" . mysqli_real_escape_string($link, $picture1),
        "content/" . mysqli_real_escape_string($link, $picture2),
        "content/" . mysqli_real_escape_string($link, $picture3),
        "content/" . mysqli_real_escape_string($link, $picture4),
        "content/" . mysqli_real_escape_string($link, $picture5));
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    return true;
}

function post_edit($link,
                   $id,
                   $title,
                   $video,
                   $picture,
                   $description,
                   $tags,
                   $picture1,
                   $picture2,
                   $picture3,
                   $picture4,
                   $picture5)
{

    $id = (int)$id;
    $title = trim($title);
    $video = trim($video);
    $picture = trim($picture);
    $description = trim($description);
    $tags = trim($tags);
    if ($title == '')
        return false;
    $sql = " UPDATE test SET title='%s', video='%s', picture='%s', description='%s', tags='%s', picture1='%s', picture2='%s', picture3='%s', picture4='%s', picture5='%s' WHERE id='%d' ";
    $query = sprintf($sql,
        mysqli_real_escape_string($link, $title),
        "content/" . mysqli_real_escape_string($link, $video),
        "content/" . mysqli_real_escape_string($link, $picture),
        mysqli_real_escape_string($link, $description),
        mysqli_real_escape_string($link, $tags),
        "content/" . mysqli_real_escape_string($link, $picture1),
        "content/" . mysqli_real_escape_string($link, $picture2),
        "content/" . mysqli_real_escape_string($link, $picture3),
        "content/" . mysqli_real_escape_string($link, $picture4),
        "content/" . mysqli_real_escape_string($link, $picture5), $id);
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    return mysqli_affected_rows($link);
}

function post_delete($link, $id)
{
    $id = (int)$id;
    if ($id == 0) {
        return false;
    }
    $query = sprintf("DELETE FROM test WHERE id='%d'", $id);
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    return mysqli_affected_rows($link);
}

function push_video($link, $user, $video)
{
    $user = trim($user);
    $video = trim($video);
    $query = sprintf("SELECT * FROM users WHERE login='%s'", $user);
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    $post = mysqli_fetch_assoc($result);
    if (!empty($post["liked"]))
        $liked_videos = explode(" ", $post["liked"]);
    $liked_videos[] = $video;
    $chk = array_unique($liked_videos);
    $update = implode(" ", $chk);
    if ($user == '') {
        return false;
    }
    $sql = " UPDATE users SET liked='%s' WHERE login='%s'";
    $query1 = sprintf($sql, mysqli_real_escape_string($link, $update), mysqli_real_escape_string($link, $user));
    $result1 = mysqli_query($link, $query1);
    if (!$result1) {
        die(mysqli_error($link));
    }
    return mysqli_affected_rows($link);
}

function get_liked($link, $user)
{
    $user = trim($user);
    $query = sprintf("SELECT * FROM users WHERE login='%s'", $user);
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    $users = mysqli_fetch_assoc($result);
    $likes = explode(" ", $users['liked']);
    return $likes;
}

function isLiked($current, $suspect)
{
    $count = 0;
    if (strcmp($current, $suspect) == 0) {
        $count++;
    } else {
        return false;
    }
    if ($count == 1)
        return true;
    return false;
}

function unlike_video($link, $user, $video)
{
    $user = trim($user);
    $video = trim($video);
    $query = sprintf("SELECT * FROM users WHERE login='%s'", $user);
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    $post = mysqli_fetch_assoc($result);
    if (!empty($post["liked"]))
        $liked_videos = explode(" ", $post["liked"]);
    for ($i = 0; $i < count($liked_videos); $i++) {
        if (strcmp($liked_videos[$i], $video) == 0) {
            $position = $i;
        }
    }
    array_splice($liked_videos, $position, 1);
    $update = implode(" ", $liked_videos);
    if ($user == '') {
        return false;
    }
    $sql = " UPDATE users SET liked='%s' WHERE login='%s'";
    $query1 = sprintf($sql, mysqli_real_escape_string($link, $update), mysqli_real_escape_string($link, $user));
    $result1 = mysqli_query($link, $query1);
    if (!$result1) {
        die(mysqli_error($link));
    }
    return mysqli_affected_rows($link);
}


function move($file1, $file2)
{
    $uploaddir = '../content/';
    $uploadfile = $uploaddir . basename($file1);//$_FILES['video']['name']
    if (move_uploaded_file($file2, $uploadfile)) {//$_FILES['video']['tmp_name']
        return true;
    } else
        return false;
}

function deleteFile($dir)
{
    if (!file_exists($dir))
        die('Файл нет существует: ' . $dir);
    unlink($dir);
    return true;
}

function putTags($link, $tags)
{
    $query = "SELECT * FROM tags_base ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $post = mysqli_fetch_assoc($result);
    if (!empty($post["tags"]))
        $tags_base = explode("+", $post["tags"]);
    $tags_base1 = explode("+", $tags);
    $result = array_merge($tags_base, $tags_base1);
    $update = implode("+", $result);//" UPDATE users SET liked='%s' WHERE login='%s'";
    $sql = " UPDATE tags_base SET tags='%s' WHERE id='%d'";
    $query1 = sprintf($sql, mysqli_real_escape_string($link, $update), 1);
    $result1 = mysqli_query($link, $query1);
    if (!$result1)
        die(mysqli_error($link));
    return mysqli_affected_rows($link);
}

function post_tags($link)
{
    $query = "SELECT * FROM tags_base ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $post = mysqli_fetch_assoc($result);
    if (!empty($post["tags"]))
        $tags_base = explode("+", $post["tags"]);
    return $tags_base;
}
?>