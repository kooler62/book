<?
ob_start();
include __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../functions.php';
echo "$_POST[author]";
$new_author = dont_hack($_POST[author]);
//добавляем атвора в базу
$sql = "INSERT INTO authors (author_name) VALUES ('".$new_author."')";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");
ob_end_flush();