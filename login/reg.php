<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" type="text/css" href="signup.css"/>
</head>
<body background="../content/bckg_img.png">
<div class="header">
    <div class="logo"><a href="../index.php"><img src="../content/omfg18.png"></a></div>
</div>
<div class="menu" align="center">
    <div class="menu_item" align="center"><a href="../index.php">Main Page</a></div>
    <div class="menu_item" align="center"><a href="../views/user_search.php">Search</a></div>
</div>
<br>
<br>
<div class="reg_wrap">
    <div class="registration_body">
        <div class="registration_form">
            <form action="save_user.php" method="post">
                Login<br><br><input name="login" type="text" size="15" maxlength="15" id="login"></input><br><br><br>
                <div class="separator"></div>
                <br><br>
                Password<br><br><input name="password" type="password" size="15" maxlength="15" id="pass"></input>
                <br><br><br>
                <div class="submit"><input type="submit" name="submit" value="Зарегистрироваться"></div>
            </form>
        </div>
        <div class="registration_form">
            <form action="testreg.php" method="post">
                Login<br><br><input name="login" id="login" type="text" size="15" maxlength="15"></input><br><br><br>
                <div class="separator"></div>
                <br><br>
                Password<br><br><input name="password" type="password" id="pass" size="15" maxlength="15"></input>
                <br><br><br>
                <div class="submit"><input type="submit" name="submit" value="Sign Up"></input></div>
            </form>
        </div>

    </div>
</div>
<!-- ======================== СЮДА НУЖНО ПРОПИСАТЬ КОНТАКТЫ ========================== -->
<div class="reg_wrap">
    <div class="description"> Type in Contacts Here</div>
</div>
<!-- ================================================================================= -->
</body>
</html>