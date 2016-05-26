<?php

function getAllContent($link)
{
    //ЗАПРОС-----------------------------------------------------------------------------------
    $query = "SELECT * FROM Content ORDER BY video_id DESC";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    //ИЗВЛЕЧЕНИЕ ИЗ БД-------------------------------------------------------------------------
    $n = mysqli_num_rows($result);
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $content[] = $row;
    }
    return $content;
}

function searchViaTags($link, $tmp)
{
    $query = "SELECT Content.*, COUNT(*) AS c
FROM Content_Tags, Tags, Content
WHERE Content_Tags.tag_id = Tags.tag_id AND Content_Tags.video_id = Content.video_id
AND tag IN (\"" . implode("\",\"", $tmp) . "\")
GROUP BY video_id";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $n = mysqli_num_rows($result);
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $content[] = $row;
    }
    return $content;
}

function getLikedVideos($link, $login)
{
    $query = sprintf("SELECT * FROM Content WHERE video_id IN
	(SELECT Likes.video_id FROM Likes WHERE
		user_id = (SELECT Users.user_id FROM Users WHERE login='%s'))", $login);
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    //ИЗВЛЕЧЕНИЕ ИЗ БД-------------------------------------------------------------------------
    $n = mysqli_num_rows($result);
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $content[] = $row;
    }
    return $content;
}

function getOnePost($link, $id_video)
{
    $query = sprintf("SELECT Content.*, Tags.tag AS post,
GROUP_CONCAT(Tags.tag)
FROM
  Content
  INNER JOIN
  Content_Tags
    ON Content.video_id = Content_Tags.video_id
  LEFT JOIN Tags
    ON Content_Tags.tag_id = Tags.tag_id
WHERE (Content.video_id = %d)", (int)$id_video);
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $post = mysqli_fetch_assoc($result);
    return $post;
}

function addContent($link,
                    $title,
                    $video,
                    $poster,
                    $description,
                    $aTags,
                    $pic1,
                    $pic2,
                    $pic3,
                    $pic4,
                    $pic5)
{
    //PREPARE
    $title = trim($title);
    $description = trim($description);
    //CHECK
    if ($title == '')
        return false;
    //INSERT TO CONTENT
    $t = "INSERT INTO Content (title, description, video_url, poster, pic1, pic2, pic3, pic4, pic5)
 VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    $query = sprintf($t,
        mysqli_real_escape_string($link, $title),
        mysqli_real_escape_string($link, $description),
        "content/" . mysqli_real_escape_string($link, $video),
        "content/" . mysqli_real_escape_string($link, $poster),
        "content/" . mysqli_real_escape_string($link, $pic1),
        "content/" . mysqli_real_escape_string($link, $pic2),
        "content/" . mysqli_real_escape_string($link, $pic3),
        "content/" . mysqli_real_escape_string($link, $pic4),
        "content/" . mysqli_real_escape_string($link, $pic5));
    $result = mysqli_query($link, $query);
    //GET VIDEO_ID AND TAGS_IDS
    $query = sprintf("SELECT video_id FROM Content WHERE title=\"%s\"", mysqli_real_escape_string($link, $title));
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $video_id = mysqli_fetch_assoc($result);

    while ($id = current($aTags)) {
        $t = "INSERT INTO Content_Tags (video_id, tag_id) VALUES('%d', '%d')";
        $query = sprintf($t, $video_id["video_id"], key($aTags) + 1);
        $result = mysqli_query($link, $query);
        next($aTags);
    }

    if (!$result)
        die(mysqli_error($link));
    return true;
}

function editPost($link,
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

    deletePost($link, $id);
    addContent($link,
        $title,
        $video,
        $picture,
        $description,
        $tags,
        $picture1,
        $picture2,
        $picture3,
        $picture4,
        $picture5);
}

function deletePost($link, $id)
{
    $id = (int)$id;
    if ($id == 0) {
        return false;
    }
    $query = sprintf("DELETE FROM Content WHERE video_id='%d'", $id);
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    return mysqli_affected_rows($link);
}

function likeVideo($link, $user, $video)
{
    $user = trim($user);
    $video = trim($video);
    $query = sprintf("SELECT user_id FROM Users WHERE login='%s'", $user);
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    $user_id = mysqli_fetch_assoc($result);
    $query1 = sprintf("SELECT video_id FROM Content WHERE video_url='%s'", $video);
    $result1 = mysqli_query($link, $query1);
    if (!$result1) {
        die(mysqli_error($link));
    }
    $video_id = mysqli_fetch_assoc($result1);

    $t = "INSERT INTO Likes (video_id, user_id) VALUES('%s', '%s')";
    $query2 = sprintf($t, $video_id["video_id"], $user_id["user_id"]);
    $result2 = mysqli_query($link, $query2);
    if (!$result2) {
        die(mysqli_error($link));
    }
    return mysqli_affected_rows($link);
}

function getLikedVideo($link, $user)
{
    $user = trim($user);
    $query = sprintf("SELECT * FROM Users WHERE login='%s'", $user);
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

function unlikeVideo($link, $user, $video)
{
    $user = trim($user);
    $video = trim($video);
    $query = sprintf("SELECT user_id FROM Users WHERE login='%s'", $user);
    $result = mysqli_query($link, $query);
    if (!$result) {
        die(mysqli_error($link));
    }
    $user_id = mysqli_fetch_assoc($result);
    $query1 = sprintf("SELECT video_id FROM Content WHERE video_url='%s'", $video);
    $result1 = mysqli_query($link, $query1);
    if (!$result1) {
        die(mysqli_error($link));
    }
    $video_id = mysqli_fetch_assoc($result1);

    $query = sprintf("DELETE FROM Likes WHERE user_id='%d' AND video_id='%d'", $user_id["user_id"], $video_id["video_id"]);
    $result = mysqli_query($link, $query);
    if (!$result) {
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

function putTags($link, $sTags)
{
    $tags = explode("+", $sTags);
    foreach ($tags as $tag) {
        $t = "INSERT INTO Tags (tag) VALUES('%s')";
        $query = sprintf($t, $tag);
        $result = mysqli_query($link, $query);
    }
}

function post_tags($link)
{
    //ЗАПРОС-----------------------------------------------------------------------------------
    $query = "SELECT tag FROM Tags";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    //ИЗВЛЕЧЕНИЕ ИЗ БД-------------------------------------------------------------------------
    $n = mysqli_num_rows($result);
    $content = array();
    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $content[$i] = $row;
    }
    return $content;
}

?>