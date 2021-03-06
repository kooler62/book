<?
include __DIR__ . '/config.php';
include_once __DIR__ . '/functions.php';

//подключаем хедер
$title = 'Каталог';
include __DIR__ . '/views/header.php';
$id = dont_hack($_GET[id],int);

if ( isset($id) && !empty($id) ) {
	$how = sql_how_where('*', 'books', "book_id=$id");
	if ($how == 0) {
		$message='<h1>К сожалению такой книги нет</h1>';
		echo $message;
		exit();
	}
	$book = sql_fetch_where('*', 'books', "book_id=$id");
	//ищем авторов по айди этой книги
	$result_2 = select_where('author','book_author',"book=$id",'');
	//сколько авторов
	$how_2 = sql_how_result($result_2);
	//если авторов больше одного используем цикл
	if ( !isset($how_2) or $how_2 == 0 ) {
		//echo nothing
	}
	else{
		// если есть 1 автор
		if ($how_2 == 1) {
			$book_2 = sql_fetch_where('author', 'book_author', "book=$id");
			$book_3 = sql_fetch_where('*', 'authors', "author_id=$book_2[author]");
			$book[book_author][author_name][$book_3[author_id]]=$book_3[author_name];
		}
		else{
			// если авторов больше одного
			for ($a=1; $a <= $how_2; $a++) { 
				$book_2 = sql_fetch_result($result_2);
				$book_3= sql_fetch_where('*', 'authors', "author_id=$book_2[author]");
				$book[book_author][author_name][$book_3[author_id]]=$book_3[author_name];
			}
		}
	}
	//ищем жанры по айди этой книги
	//сколько жанров
	$result_5 = select_where('genre','book_genre',"book=$id",'');
	$how_5 = sql_how_result($result_5);
	//если жанров больше одного используем цикл
	if ( !isset($how_5) or $how_5 == 0 ) {
		//echo nothing
	}
	else{
		// если есть 1 жанр
		if ($how_5 == 1) {
			$book_5 = sql_fetch_result($result_5);
			$book_4 = sql_fetch_where('*', 'genres', "genre_id=$book_5[genre]");
			$book[book_genre][genre_name][$book_4[genre_id]]=$book_4[genre_name];
		}
		else{
		// если жанров больше одного
			for ($a=1; $a <= $how_5; $a++) { 
				$book_5 = sql_fetch_result($result_5);
				$book_4 = sql_fetch_where('*', 'genres', "genre_id=$book_5[genre]");
				$book[book_genre][genre_name][$book_4[genre_id]]=$book_4[genre_name];
			}
		}
	}
}
//подключаем вид книги
include __DIR__ . '/views/book.php';
//подключаем форму заказа
include __DIR__ . '/views/order.php';
//подключаем футер
include __DIR__ . '/views/footer.php';