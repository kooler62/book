<?
ob_start();
include __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../functions.php';
echo "$_POST[genre]";
$new_genre = dont_hack($_POST[genre]);
//добавляем атвора в базу
sql_insert_one('genres','genre_name',$new_genre);
//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");
ob_end_flush();