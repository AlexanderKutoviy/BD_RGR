<?php
session_start();
require_once("../database.php");
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
if (empty($login) or empty($password)) {//если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!");
}
//если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
//удаляем лишние пробелы
$login = trim($login);
$password = trim($password);
// подключаемся к базе
//include ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь
// минипроверка на подбор паролей
$ip = getenv("HTTP_X_FORWARDED_FOR");
/*if (empty($ip) || $ip=='unknown') { $ip=getenv("REMOTE_ADDR"); }
mysqli_query($link, "DELETE FROM ips WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 900");//удаляем ip-адреса ошибавшихся при входе пользователей через 15 минут.
$query = sprintf("SELECT col FROM ips WHERE ip='%s'", $ip);
$result = mysqli_query($link, $query);// извлекаем из базы колличество неудачных попыток входа за последние 15 минут у пользователя с данным ip
$myrow = mysqli_fetch_array($result);
if ($myrow['col'] > 3) {
//если таковых попыток больше трех, то выдаем сообщение.
print ($password);
exit("Вы набрали логин или пароль неверно 3 раза. Подождите 15 минут до следующей попытки.");
}*/
$password = md5($password);//шифруем пароль
$password = strrev($password);//реверс
$password = $password . "b3p6f";
$query = sprintf("SELECT * FROM Users WHERE login='%s' AND password='%s'", $login, $password);
$result = mysqli_query($link, $query); //извлекаем из базы все данные о пользователе с введенным логином
$myrow = mysqli_fetch_array($result);
if (empty($myrow['user_id'])) {
    //если пользователя с введенным логином и паролем не существует,то записываем ip пользователя и с датой ошибки
    $q1 = sprintf("SELECT ip FROM ips WHERE ip='%s' ", $ip);
    $select = mysqli_query($link, $q1);
    $tmp = mysqli_fetch_row($select);
    if ($ip == $tmp[0]) {
        //проверяем, есть ли пользователь в таблице "ips"
        $q2 = sprintf("SELECT col FROM ips WHERE ip='%s'", $ip);
        $result52 = mysqli_query($link, $q2);
        $myrow52 = mysqli_fetch_array($result52);
        $col = $myrow52[0] + 1;
        $q3 = sprintf("UPDATE ips SET col='%d',date=NOW() WHERE ip='%s'", $col, $ip);
        $rrr = mysqli_query($link, $q3);
    } else {
        mysqli_query($link, "INSERT INTO ips (ip,date,col) VALUES ('$ip',NOW(),'1')");
    }
    exit ("Извините, введённый вами логин или пароль неверный.");
} else {
    $_SESSION['password'] = $myrow['password'];
    $_SESSION['login'] = $myrow['login'];
    $_SESSION['id'] = $myrow['user_id'];
    if (isset($_POST['save'])) {
        setcookie("login", $_POST["login"], time() + 9999999);
        setcookie("password", $_POST["password"], time() + 9999999);
    }
}
echo "<html><head><meta http-equiv='Refresh' content='0; URL=../index.php'></head></html>";
?>