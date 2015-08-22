<?
//подключение к базе
include __DIR__ . '/models/bd.php';

//подключаем хедер
$title = 'Каталог';
include __DIR__ . '/views/header.php';

// функция защиты параметров
include __DIR__ . '/inc/funcs.php';

$id = dont_hack($_GET[id],int);
$name = dont_hack($_GET[name],int);
if ( isset($name) && !empty($name) ) {
	//если есть имя автора и оно не пустое
	$select_sql = "SELECT * FROM authors WHERE book_id=$id";
}
if ( isset($id) && !empty($id) ) {
	$select_sql = "SELECT * FROM books WHERE book_id=$id";
	$result = mysqli_query($db, $select_sql) or die('404');
	$how = mysqli_num_rows($result);
	if ($how == 0) {
		echo "<h1>К сожалению такой книги нет</h1>";
		exit();
	}
	$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
	echo '<img src="';
	echo $myrow[book_img];
	echo '">';
	echo '<h1>' . $myrow[book_title] . '</h1>';
	echo "<h3>";
	//ищем авторов по айди этой книги
	$select_sql_2 = "SELECT author FROM book_author WHERE book=$id";
	$result_2 = mysqli_query($db, $select_sql_2) or die(mysqli_error($db));
	//сколько авторов
	$how_2 = mysqli_num_rows($result_2);
	//если авторов больше одного используем цикл
	if ( !isset($how_2) or $how_2 == 0 ) {
		//echo nothing
	}
	else{
		// если есть 1 автор
		if ($how_2 == 1) {
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
			$select_sql_3 = "SELECT * FROM authors WHERE author_id=$myrow_2[author]";
			$result_3 = mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
			$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
			echo "<h3><a href=\"/author.php/?id=$myrow_3[author_id]\">$myrow_3[author_name]</a></h3>";
		}
		else{
			// если авторов больше одного
			echo "<h3>";
			for ($a=1; $a <= $how_2; $a++) { 
				$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
					$select_sql_3 = "SELECT * FROM authors WHERE author_id=$myrow_2[author]";
					$result_3  =mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
					$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
					echo "<span><a href=\"/author.php/?id=$myrow_3[author_id]\">$myrow_3[author_name]</a></span>";
			}echo "</h3>";
		}
	}
	//ищем жанры по айди этой книги
	$select_sql_5 = "SELECT genre FROM book_genre WHERE book=$id";
	$result_5 = mysqli_query($db, $select_sql_5) or die(mysqli_error($db));
	//сколько авторов
	$how_5 = mysqli_num_rows($result_5);
	//если жанров больше одного используем цикл
	if ( !isset($how_5) or $how_5 == 0 ) {
		//echo nothing
	}
	else{
		// если есть 1 автор
		if ($how_5 == 1) {
			$myrow_5 = mysqli_fetch_array($result_5, MYSQLI_ASSOC);
			$select_sql_4 = "SELECT * FROM genres WHERE genre_id=$myrow_5[genre]";
			$result_4 = mysqli_query($db, $select_sql_4) or die(mysqli_error($db));
			$myrow_4 = mysqli_fetch_array($result_4, MYSQLI_ASSOC);
		echo "<h2><a href=\"/genre.php/?id=$myrow_4[genre_id]\">$myrow_4[genre_name]</a></h2>";
		}
		else{
		// если авторов больше одного
		echo "<h2>";
			for ($a=1; $a <= $how_5; $a++) { 
				$myrow_5 = mysqli_fetch_array($result_5, MYSQLI_ASSOC);
				$select_sql_4 = "SELECT * FROM genres WHERE genre_id=$myrow_5[genre]";
				$result_4 = mysqli_query($db, $select_sql_4) or die(mysqli_error($db));
				$myrow_4 = mysqli_fetch_array($result_4, MYSQLI_ASSOC);
				echo "<span><a href=\"/genre.php/?id=$myrow_4[genre_id]\">$myrow_4[genre_name]</a></span>";
			}echo "</h2>";
		}
	}
	echo '<h3>' . $myrow[book_genre] .'</h3>';
}
//подключаем вид книги
include __DIR__ . '/views/book.php';

//подключаем форму заказа
include __DIR__ . '/views/order.php';

//подключаем футер
include __DIR__ . '/views/footer.php';