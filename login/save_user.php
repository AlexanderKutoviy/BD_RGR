<?php
require_once("../database.php");
// подключаемся к базе
$link = db_connect();
if (isset($_POST['login'])) {
    $login = $_POST['login'];
    if ($login == '') {
        unset($login);
    }
}
//заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    if ($password == '') {
        unset($password);
    }
}
//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) { //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
}
//если логин и пароль введены, то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);
$password = md5($password);//шифруем пароль
$password = strrev($password);//реверс
$password = $password . "b3p6f";
$query = sprintf("SELECT * FROM users WHERE login='%s'", $login);
$result = mysqli_query($link, $query);
$myrow = mysqli_fetch_assoc($result);
if (!empty($myrow['id'])) {
    exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
}
// если такого нет, то сохраняем данные
$t = "INSERT INTO users (login,password) VALUES('%s','%s')";
$query = sprintf($t, $login, $password);
$result2 = mysqli_query($link, $query);
// Проверяем, есть ли ошибки
if ($result2 == 'TRUE') {
    echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='../index.php'>Главная страница</a>";
} else {
    echo "Ошибка! Вы не зарегистрированы.";
    echo $login;
    echo $password;
}
?>