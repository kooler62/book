<?
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../functions.php';
//подключаем хедер
$title = 'Каталог';
include __DIR__ . '/views/header.php';
//если есть параметра search подключаем вывод резльтатов по поиску
if ( isset($_GET[search]) && !empty($_GET[search]) ) {
	$title = 'Результаты поиска';
	include __DIR__ . '/inc/search_result.php';
}
//узнаем сколько всего книг и передадим значение для страничной навигации
$how_pages = sql_how('book_id', 'books');
//проверка на наличие параметра GET[page]
if ( isset($_GET[page]) && !empty($_GET[page]) ) {
	$page = dont_hack($_GET[page],int);
	$offset = ($page - 1) * 12;
	$result=select_end('*','books',"ORDER BY book_id DESC LIMIT $offset,12",'');
}
else{
	$result=select_end('*','books',"ORDER BY book_id DESC LIMIT 12",'');
}
$how = sql_how_result($result);
for ($i=0; $i < $how; $i++) { 
	$myrow = sql_fetch_result($result);
	$books[$i]=$myrow;
	//вытаскиваем в цикле авторов, если есть
	$result_2=select_where('author','book_author',"book=$myrow[book_id]",'');
	//сколько авторов
	$how_2 = sql_how_result($result_2);
	//если авторов больше одного используем цикл
	if ($how_2 >1 && $how_2!=0) {
		for ($a=1; $a <= $how_2; $a++) {
			$myrow_2 = sql_fetch_result($result_2);
			$result_3=select_where('*','authors',"author_id=$myrow_2[author]",'');
			$myrow_3 = sql_fetch_result($result_3);
			$books[$i][author][]=$myrow_3;
		}
	}
	else{
		//если нет автора
		if ($how_2 == 0) {$books[$i][author][][author_name]='<br>';}
		else{
			//если есть (один)
			$myrow_2 = sql_fetch_result($result_2);
			$result_3=select_where('*','authors',"author_id=$myrow_2[author]",'');
			$myrow_3 = sql_fetch_result($result_3);
			$books[$i][author][]=$myrow_3;
		}
	}
}
include __DIR__ . '/views/books.php';
include __DIR__ . '/../views/nav.php';
include __DIR__ . '/views/footer.php';