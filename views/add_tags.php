<!DOCTYPE html>
<html>

<head>
    <title>Home page</title>
    <link rel="stylesheet" type="text/css" href="../views/style_add.css"/>
</head>

<body>

<div>
    <form method="post" action="index.php?action=put">
        <label>
            Tags
            <textarea class="form-item" name="tags" required></textarea>
        </label>
        <input type="submit" value="Сохранить" class="btn">
    </form>
</div>

</body>
</html>