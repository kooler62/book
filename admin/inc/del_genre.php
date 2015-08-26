<?
include __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../functions.php';
//удаляем жанр
$id = dont_hack($_GET[id],int);
//запрос к базе чтобы проверить есть ли на писаные ним книги
//запрашиваем книги этого жанра
$how = sql_how_where('book', 'book_genre', "genre=$id");
if ($how == 0) {
	// у автора нет книг, можем спокойно его удалять
	$result_del = sql_del('genres', "genre_id=$id");
	//возвращаем назад
	header("Location: /admin/genre.php");
}
else{
	$title = 'Ошибка';
	include __DIR__ . '/../views/header.php';
	echo "Вы не можете удалить жанр в котором есть книги";
}