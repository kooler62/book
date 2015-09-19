<?
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../functions.php';
$search = dont_hack($_GET[search]);
$result = sql_search('book_id,book_title','books','book_title',"$search");
$how = sql_how_result($result);
echo "По запросу '".$search."' найдено  $how результатов<br><hr>";

for ($i=0; $i < $how; $i++) { 
	$row = sql_fetch_result($result);
	$cc = $row[cat];
	//подбираем категорию
	$result_c= select_where('book_id,book_title', 'books',"book_id='".$cc."'",'');
	$row_c = sql_fetch_result($result_c);
	//вхождение и искомое слово обрамляем маркером
	$text_mark = str_replace("$search", "<mark>$search</mark>", "$row[book_title]");
	echo "<a href=\"/book.php/?id=$row[book_id]\">$text_mark</a>";
	echo "<br>";
}
exit();