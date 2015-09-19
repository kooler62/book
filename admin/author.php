<?
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../functions.php';

//подключаем хедер
$title='Авторы';
include __DIR__ . '/views/header.php';
include __DIR__ . '/views/add_author.php';
$id=dont_hack($_GET[id],int);

if ( isset($_GET[id]) && !empty($_GET[id]) ) {
	//если есть идентификатор автора
	$myrow_1=sql_fetch_where('*', 'authors', "author_id=$id");
	if ($myrow_1[author_name]=='') {
		$message='нет такого автора!';
	}
	else{
		$start_message="Вcе книги автора $myrow_1[author_name]:";
	}	
	$result = select_where('book','book_author',"author=$id",'');
	$how = sql_how_where('book','book_author',"author=$id");
	if ($how == 0) {
		$message='<br> 0 результатов';
	}
	else{
		for ($i=0; $i < $how; $i++) { 
			$myrow = sql_fetch_result($result);
			$myrow_2 = sql_fetch_where('*','books',"book_id=$myrow[book]");
			$book[$i][book_id]=$myrow_2[book_id];
			$book[$i][book_title]=$myrow_2[book_title];
		}
	}
}
else{
	//если нет $_GET[id] жанра, выведем все жанры
	//узнаем сколько всего страниц
	$how_pages = sql_how('author_id','authors');
	if (isset($_GET[page]) && !empty($_GET[page])) {
		$page = dont_hack($_GET[page],int);
		$offset = ($page-1)*12;
		$result_1 = sql_limit('*','authors',"$offset,12");
		for ($i=0; $i < $how_pages-1; $i++) { 
			$myrow_1 = sql_fetch_result($result_1);
			$author[$i][author_id] = $myrow_1[author_id];
			$author[$i][author_name] = $myrow_1[author_name];
		}
	}
	else{
		$result_1 = sql_limit('*','authors','12');
		if ($how_pages>=12) {
			//присваеваем другой переменоой, чтоб не сбить страничную навигацию
			$how_a=12;
		}
		else{
		$how_a=$how_pages;
		}
		for ($i=0; $i < $how_a; $i++) { 
			$myrow_1 = sql_fetch_result($result_1);
			$author[$i][author_id] = $myrow_1[author_id];
			$author[$i][author_name] = $myrow_1[author_name];
		}
	}
}
include __DIR__ . '/views/author.php';
// подключаем пагинацию
include __DIR__ . '/../views/nav.php';