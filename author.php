<?
//подключение к базе
include __DIR__ . '/config.php';

//подключаем хедер
$title = 'Авторы';
include __DIR__ . '/views/header.php';
include_once __DIR__ . '/inc/funcs.php';
$id = dont_hack($_GET[id],int);

echo "<section class=\"authors\">";
if ( isset($_GET[id]) && !empty($_GET[id]) ) {
	$select_sql_1 = "SELECT * FROM authors WHERE author_id=$id";
	$result_1 = mysqli_query($db, $select_sql_1) or die(mysqli_error($db));
	$myrow_1 = mysqli_fetch_array($result_1, MYSQLI_ASSOC);
	echo "Вcе книги автора $myrow_1[author_name]:";
	
	$select_sql = "SELECT book FROM book_author WHERE author=$id";
	$result = mysqli_query($db, $select_sql) or die(mysqli_error($db));
	$how = mysqli_num_rows($result);
	if ($how == 0) {
		echo "<br> 0 результатов";
	}
	else{
		for ($i=0; $i < $how; $i++) { 
			$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$select_sql_2 = "SELECT * FROM books WHERE book_id=$myrow[book]";
			$result_2 = mysqli_query($db, $select_sql_2) or die(mysqli_error($db));
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
			echo "<h2><a href=\"/book.php?id=$myrow_2[book_id]\">$myrow_2[book_title]</a></h2>";
		}
	}
}
else{
	//если нет $_GET[id] жанра, выведем все жанры
	//узнаем сколько всего страниц
	$select_sql_100 = "SELECT author_id FROM authors";
	$result_100 = mysqli_query($db, $select_sql_100) or die(mysqli_error($db));
	$how_pages = mysqli_num_rows($result_100);

	if ( isset($_GET[page]) && !empty($_GET[page]) ) {
		$page = dont_hack($_GET[page],int);
		$offset = ($page - 1) * 12;
		$select_sql_1="SELECT * FROM authors LIMIT $offset, 12";
	}
	else{
		$select_sql_1 = "SELECT * FROM authors LIMIT 12";
	}
	$result_1 = mysqli_query($db, $select_sql_1) or die(mysqli_error($db));
	//echo "$how_pages";
	for ($i=0; $i < $how_pages-1; $i++) { 
		$myrow_1 = mysqli_fetch_array($result_1, MYSQLI_ASSOC);
		echo "<a href=\"/author.php/?id=$myrow_1[author_id]\">$myrow_1[author_name]</a><br>";
	}
}
echo "</section>";
// подключаем пагинацию
echo "<nav>";
echo pagination($how_pages);
echo "</nav>";