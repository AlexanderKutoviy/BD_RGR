<!DOCTYPE html>
<html>
<head>
    <title>Home page</title>
    <link rel="stylesheet" type="text/css" href="../views/style_add.css"/>
</head>

<body>
<div>
    <form method="post" enctype="multipart/form-data"
          action="index.php?action=<?= $_GET['action'] ?>&id=<?= $_GET['id'] ?>">
        <label>
            Title
            <input type="text" name="title" value="" class="form-item" autofocus required>
        </label>
        <br>
        <br>
        <label>
            Video
            <input type="file" name="video">
        </label>
        <br>
        <br>
        <label>
            Poster
            <input type="file" name="picture">
        </label>
        <br>
        <br>
        <label>
            Description
            <textarea class="form-item" name="description" required></textarea>
        </label>
        <br>
        <br>
        <?php
        for ($i = 0; $i < count($tags_base); $i++) {
            ?>
            <input type="checkbox" name="tags[<?= $i ?>]" id="tag<?= $i ?>" class="hide-checkbox"
                   value="<?= $tags_base[$i]["tag"] ?>">
            <label for="tag<?= $i ?>"><?= $tags_base[$i]['tag'] ?></label>
        <?php } ?>
        <br>
        <br>
        <label>
            Picture1
            <input type="file" name="picture1" value="">
        </label>
        <br>
        <br>
        <label>
            Picture2
            <input type="file" name="picture2">
        </label>
        <br>
        <br>
        <label>
            Picture3
            <input type="file" name="picture3">
        </label>
        <br>
        <br>
        <label>
            Picture4
            <input type="file" name="picture4">
        </label>
        <br>
        <br>
        <label>
            Picture5
            <input type="file" name="picture5">
        </label>
        <br>
        <br>
        <input type="submit" value="Сохранить" class="btn">
    </form>
</div>
</body>
</html>
    