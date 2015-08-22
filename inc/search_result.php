<?
$search = htmlentities(trim($_GET[search]));

include __DIR__ . '/../models/bd.php';

$sql = "SELECT book_id,book_title FROM books WHERE MATCH(book_title) AGAINST('".$search."')";
$result = mysqli_query($db,$sql)or die(mysqli_error($db));
$how = mysqli_num_rows($result);

echo "По запросу '".$search."' найдено  $how результатов<br><hr>";

for ($i=0; $i < $how; $i++) { 
	$row = mysqli_fetch_assoc($result);
	$cc = $row[cat];
	//подбираем категорию
	$sql_c = "SELECT book_id,book_title FROM books WHERE book_id='".$cc."'";
	$result_c = mysqli_query($db,$sql_c)or die(mysqli_error($db));
	$row_c = mysqli_fetch_assoc($result_c);
	//вхождение и искомое слово обрамляем маркером
	$text_mark = str_replace("$search", "<mark>$search</mark>", "$row[book_title]");
	echo "<a href=\"/book.php/?id=$row[book_id]\">$text_mark</a>";
	echo "<br>";
}
exit();