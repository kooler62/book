<?
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../functions.php';

//подключаем хедер
$title = 'Жанры';
include __DIR__ . '/views/header.php';
include __DIR__ . '/views/add_genre.php';
$id = dont_hack($_GET[id],int);

if ( isset($_GET[id]) && !empty($_GET[id]) ) {
	//если есть идентификатор жанра
	$myrow_1=sql_fetch_where('*', 'genres', "genre_id=$id");
	if ($myrow_1[genre_name]=='') {
		$message='нет такого жанра!';
	}
	else{
		$start_message="Вcе книги жанра $myrow_1[genre_name]:";
	}	
	$result = select_where('book','book_genre',"genre=$id",'');
	$how = sql_how_where('book','book_genre',"genre=$id");
	if ($how == 0) {
		$message='<br> 0 результатов';
		//echo "$message";
	}
	else{
		for ($i=0; $i < $how; $i++) { 
			$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$myrow_2 = sql_fetch_where('*','books',"book_id=$myrow[book]");
			$book[$i][book_id]=$myrow_2[book_id];
			$book[$i][book_title]=$myrow_2[book_title];
		}
	}
}
else{
	//если нет $_GET[id] жанра, выведем все жанры
	//узнаем сколько всего страниц
	$how_pages = sql_how('genre_id','genres');
	if (isset($_GET[page]) && !empty($_GET[page])) {
		$page = dont_hack($_GET[page],int);
		$offset = ($page-1)*12;
		$result_1 = sql_limit('*','genres',"$offset,12");
		for ($i=0; $i < $how_pages-1; $i++) { 
			$myrow_1 = mysqli_fetch_array($result_1, MYSQLI_ASSOC);
			$genre[$i][genre_id]=$myrow_1[genre_id];
			$genre[$i][genre_name]=$myrow_1[genre_name];
		}
	}
	else{
		$result_1 = sql_limit('*','genres','12');
		if ($how_pages>=12) {
			//присваеваем другой переменоой, чтоб не сбить страничную навигацию
			$how_a=12;
		}
		else{
		$how_a=$how_pages;
		}
		for ($i=0; $i < $how_a; $i++) { 
			$myrow_1 = mysqli_fetch_array($result_1, MYSQLI_ASSOC);
			$genre[$i][genre_id]=$myrow_1[genre_id];
			$genre[$i][genre_name]=$myrow_1[genre_name];

		}
	}
}
include __DIR__ . '/views/genre.php';
// подключаем пагинацию
include __DIR__ . '/../views/nav.php';