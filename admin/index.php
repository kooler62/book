<?
include __DIR__ . '/../models/bd.php';
//подключаем хедер
include __DIR__ . '/../inc/ad_mail.php';
$title='Каталог';
include __DIR__ . '/views/header.php';
include __DIR__ . '/inc/functions.php';
?><section><?

//если есть параметра search подключаем вывод резльтатов по поиску
if ( isset($_GET[search]) && !empty($_GET[search]) ) {
	include __DIR__ . '/inc/search_result.php';
}
//узнаем сколько всего книг и передадим значение для страничной навигации
$for_page = "SELECT book_id FROM books";
$page_result = mysqli_query($db, $for_page) or die(mysqli_error($db));
//сколько всего книг, подключаем пагинацию
$how_pages = mysqli_num_rows($page_result);

//проверка на наличие параметра GET[page]
if ( isset($_GET[page]) && !empty($_GET[page]) ) {
	$page = dont_hack($_GET[page],int);
	$offset = ($page - 1) * 12;
	$select_sql = "SELECT * FROM books ORDER BY book_id DESC LIMIT $offset, 12 ";
	$result = mysqli_query($db, $select_sql) or die(mysqli_error($db));
	//сколько всего книг, подключаем пагинацию
	$how = mysqli_num_rows($result);
}
else{
	$select_sql = "SELECT * FROM books ORDER BY book_id DESC LIMIT 12";
	$result = mysqli_query($db, $select_sql) or die(mysqli_error($db));
	//сколько всего книг, подключаем пагинацию
	$how = mysqli_num_rows($result);
}
for ($i=0; $i < $how; $i++) { 
	$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
	echo "<article><div class=\"book_title\">";
	echo "<h2 title=\"$myrow[book_title]\"><a href=\"/admin/book.php/?id=$myrow[book_id]\">";
	echo "$myrow[book_title]</a></h2></div>";
	echo "<div class=\"img_bg\">";
	echo "<a href=\"/admin/book.php/?id=$myrow[book_id]\"><img src=\"$myrow[book_img]\"></a></div>";
	echo "<div class=\"boto\">";

	//вытаскиваем в цикле авторов, если есть
	$select_sql_2 = "SELECT author FROM book_author WHERE book=$myrow[book_id]";//.$myrow[book_author];
	$result_2 = mysqli_query($db, $select_sql_2) or die(mysqli_error($db));
	//сколько авторов
	$how_2 = mysqli_num_rows($result_2);

	//если авторов больше одного используем цикл
	if ($how_2 >1 && $how_2!=0) {
		echo "<h3>";
		for ($a=1; $a <= $how_2; $a++) { 
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
			$select_sql_3 = "SELECT * FROM authors WHERE author_id=$myrow_2[author]";//.$myrow[book_author];
			$result_3 = mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
			$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
			echo "<span><a href=\"/admin/author.php/?id=$myrow_3[author_id]\">$myrow_3[author_name]</a></span>";
		}
		echo "</h3>";
	}
	else{
		//если нет автора
		if ($how_2 == 0) {echo "<h3></h3><br>";}
		else{
			//если есть (один)
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
			$select_sql_3="SELECT * FROM authors WHERE author_id=$myrow_2[author]";//.$myrow[book_author];
			$result_3=mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
			$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
			echo "<h3><a href=\"/admin/author.php/?id=$myrow_3[author_id]\">$myrow_3[author_name]</a></h3>";
		}
	}
	echo "<button>$myrow[book_price] грн.</button>";
	echo "</div>";
	echo "</article>";
}
?>
	</section>
	<nav>
<?
// подключаем пагинацию
echo pagination($how_pages);
?>
</nav>
<?
include __DIR__ . '/views/footer.php';