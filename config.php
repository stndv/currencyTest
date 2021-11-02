<?php

$link = mysqli_connect('localhost', 'root', NULL);
if (!$link) {
    die('Не удалось соединиться : ' . mysql_error());
}

// выбираем foo в качестве текущей базы данных
$db_selected = mysqli_select_db( $link, 'currencytest');
if (!$db_selected) {
    die ('Не удалось выбрать базу foo: ' . mysql_error());
}