<?
ob_start();
include '../../inc/bd.php';
include '../../inc/translit.php';

echo "$_POST[author]";

$new_author = htmlentities(trim($_POST[author]));
//транислит
//$new_author_translit=translit($new_author);
//добавляем атвора в базу
$sql = "INSERT INTO authors (author_name)
VALUES ('".$new_author."')";

$result = mysqli_query($db, $sql) or die(mysqli_error($db));

//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");
ob_end_flush();