<?
ob_start();
include __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../functions.php';
echo "$_POST[author]";
$new_author = dont_hack($_POST[author]);
//добавляем атвора в базу
sql_insert_one('authors','author_name',$new_author);
//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");
ob_end_flush();