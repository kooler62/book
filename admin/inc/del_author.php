<?
include __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../functions.php';
//удаляем автора
$id = dont_hack($_GET[id],int);
//запрос к базе чтобы проверить есть ли на писаные ним книги
//запрашиваем книги этого автора
$how = sql_how_where('book', 'book_author', "author=$id");
if ($how == 0) {
	// у автора нет книг, можем спокойно его удалять
	$result_del = sql_del('authors', "author_id=$id");
	//возвращаем назад
	header("Location: /admin/author.php");
}
else{
	$title = 'Ошибка';
	include __DIR__ . '/../views/header.php';
	echo "Вы не можете удалить автора, у которого есть книги";
}