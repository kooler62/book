<?
ob_start();
include __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../functions.php';
echo "$_POST[genre]";
$new_genre = dont_hack($_POST[genre]);
//добавляем атвора в базу
$sql = "INSERT INTO genres (genre_name) VALUES ('".$new_genre."')";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");
ob_end_flush();