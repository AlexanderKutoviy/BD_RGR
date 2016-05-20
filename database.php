<?php
define('MYSQL_SERVER', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DB', 'caption');

function db_connect()
{
    $link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB) or die("error: " . mysqli_error($link));
    if (!mysqli_set_charset($link, "utf8")) {
        printf("error: " . mysqli_error($link));
    }
    return $link;
}
?>