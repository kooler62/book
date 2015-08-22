<?
ob_start();
include __DIR__ . '/../../inc/bd.php';
include __DIR__ . '/../../inc/translit.php';

echo "$_POST[genre]";

$new_genre = htmlentities(trim($_POST[genre]));
//транислит
//$new_author_translit=translit($new_author);
//добавляем атвора в базу
$sql = "INSERT INTO genres (genre_name)
VALUES ('".$new_genre."')";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));

//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");
ob_end_flush();