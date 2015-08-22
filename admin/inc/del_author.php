<?
include __DIR__ . '/../../inc/bd.php';
//удаляем автора

$id = htmlentities(trim($_GET[id]))*1;
//запрос к базе чтобы проверить есть ли на писаные ним книги
//запрашиваем книги этого автора
$sql = "SELECT book FROM book_author WHERE author=$id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$how = mysqli_num_rows($result);
if ($how == 0) {
	// у автора нет книг, можем спокойно его удалять
	$sql_del = "DELETE FROM authors WHERE author_id=$id";
	$result_del = mysqli_query($db, $sql_del) or die(mysqli_error($db));
	//возвращаем назад
	header("Location: /admin/author.php");
}
else{
	$title = 'Ошибка';
	include __DIR__ . '/../views/header.php';
	echo "Вы не можете удалить автора, у которого есть книги";
}