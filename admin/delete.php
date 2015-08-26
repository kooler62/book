<?
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../functions.php';
//вытащим id из REFERER http://book/admin/book.php/?id= 31 символа
$book_id = substr($_SERVER[HTTP_REFERER],31);
$book_id = dont_hack($book_id,int);
// удалим инфу из таблицы books
$result = sql_del('books',"book_id=$book_id");
//теперь удалим авторов 
$result1 = sql_del('book_author',"book=$book_id");
//удалим жанры
$result2 = sql_del('book_genre',"book=$book_id");
//посылаем назад
header("Location: /admin");