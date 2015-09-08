<?
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../functions.php';

//подключаем хедер
$title = 'Книга';
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
	$result_2=select_where('author','book_author',"book=$id",'');


	//сколько авторов
	$how_2 = mysqli_num_rows($result_2);
	//если авторов больше одного используем цикл
	if ( !isset($how_2) or $how_2 == 0) {
		//echo nothing
	}
	else{
		// если есть 1 автор
		if ($how_2 == 1) {
			$book_2 = sql_fetch_where('author', 'book_author', "book=$id");
			$book_3 = sql_fetch_where('*', 'authors', "author_id=$book_2[author]");
			$author=$book_3[author_name];
	}
	else{
		// если авторов больше одного
			for ($a=1; $a <= $how_2; $a++) { 
				$book_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
				$book_3= sql_fetch_where('*', 'authors', "author_id=$book_2[author]");
				$book[book_author][author_name][$book_3[author_id]]=$book_3[author_name];
				//знаки пунктуации
				if($a == $how_2){
					$book_author=$book_3[author_name];}
				else{$book_author="$book_3[author_name], ";}
				$author.=$book_author;
			}
		}
	}
	//ищем жанры по айди этой книги
	$result_2=select_where('genre','book_genre',"book=$id",'');
	//сколько жанров
	$how_2 = mysqli_num_rows($result_2);
	//если жанров больше одного используем цикл
	if ( !isset($how_2) or $how_2==0 ) {
		//echo nothing
	}
	else{
	// если есть 1 жанр
		if ($how_2 == 1) {
			$book_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
			$book_3 = sql_fetch_where('*', 'genres', "genre_id=$book_2[genre]");
			$genre=$book_3[genre_name];
	}
	else{
		// если жанров больше одного
			for ($a=1; $a <= $how_2; $a++) { 
				$book_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
				$book_3 = sql_fetch_where('*', 'genres', "genre_id=$book_2[genre]");
				if($a == $how_2){
					$book_genre=$book_3[genre_name];}
				else{
					$book_genre="$book_3[genre_name], ";}
				$genre.=$book_genre;
			}
		}
	}
}
//подключаем вид книги
include __DIR__ . '/views/book.php';