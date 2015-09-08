<?
include __DIR__ . '/config.php';
include_once __DIR__ . '/functions.php';
//подключаем хедер
$title = 'Каталог';
include __DIR__ . '/views/header.php';

//если есть параметра search подключаем вывод резльтатов по поиску
if (isset($_GET['search']) && !empty($_GET['search'])) {
	$title = 'Результаты поиска';
	include __DIR__ . '/inc/search_result.php';
}
//узнаем сколько всего книг и передадим значение для страничной навигации
$for_page = "SELECT book_id FROM books";
$page_result = mysqli_query($db, $for_page) or die(mysqli_error($db));
//сколько всего книг, подключаем пагинацию
$how_pages = mysqli_num_rows($page_result);
//проверка на наличие параметра GET[page]
if (isset($_GET['page']) && !empty($_GET['page'])) {
	$page = dont_hack($_GET['page'],int);
	$offset = ($page - 1) * 12;
	$result=select_end('*','books',"ORDER BY book_id DESC LIMIT $offset,12",'');
}
else{
	$result=select_end('*','books',"ORDER BY book_id DESC LIMIT 12",'');	
}
//сколько всего книг(для пагинации)
$how = mysqli_num_rows($result);
//тк нумерация с нуля а количество нет
for ($i=0; $i < $how; $i++) {
	$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$books[$i]=$myrow;
	//вытаскиваем в цикле авторов, если есть
	$result_2=select_where('author','book_author',"book=$myrow[book_id]",'');
	//сколько авторов
	$how_2 = mysqli_num_rows($result_2);
	//если авторов больше одного используем цикл
	if ($how_2 >1 && $how_2 != 0) {
		for ($a=1; $a <= $how_2; $a++) { 
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
			$result_3=select_where('*','authors',"author_id=$myrow_2[author]",'');
			$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
			$books[$i][author][]=$myrow_3;
		}
	}
	else{
		//если нет автора
		if ($how_2 == 0) {$books[$i][author][][author_name]='<br>';}
		else{
			//если есть (один)
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
			$result_3=select_where('*','authors',"author_id=$myrow_2[author]",'');
			$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
			$books[$i][author][]=$myrow_3;
		}
	}
}
include __DIR__ . '/views/books.php';
include __DIR__ . '/views/nav.php';
include __DIR__ . '/views/footer.php';