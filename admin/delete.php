<?
include __DIR__ .'/models/bd.php';

//вытащим id из REFERER http://book/admin/book.php/?id= 31 символа
$book_id = substr($_SERVER[HTTP_REFERER],31);
$book_id = htmlentities(trim($book_id))*1;

// удалим инфу из таблицы books
$select_sql = "DELETE FROM books
WHERE book_id=$book_id";

//echo "$select_sql";
$result = mysqli_query($db, $select_sql) or die(mysqli_error($db));

//теперь удалим авторов 
$select_sql1 = "DELETE FROM book_author
WHERE book = $book_id";
$result1 = mysqli_query($db, $select_sql1) or die(mysqli_error($db));

//удалим жанры
$select_sql2 = "DELETE FROM book_genre
WHERE book = $book_id";
$result2 = mysqli_query($db, $select_sql2) or die(mysqli_error($db));

//посылаем назад
header("Location: /admin");