<?
include __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../functions.php';
$search=dont_hack($_GET[search]);


$sql = "SELECT book_id,book_title FROM books WHERE MATCH(book_title) AGAINST('".$search."')";
$result = mysqli_query($db,$sql)or die(mysqli_error($db));
$how = mysqli_num_rows($result);

echo "По запросу '".$search."' найдено  $how результатов:<br><hr>";

for ($i=0; $i < $how; $i++) {
	$row = mysqli_fetch_assoc($result);
	$cc = $row[cat];
	//подбираем категорию
	$row_c=sql_fetch_where('book_id,book_title', 'books',"book_id='".$cc."'");
	//вхождение и искомое слово обрамляем маркером
	$text_mark = str_replace("$search", "<mark>$search</mark>", "$row[book_title]");
	echo "<a href=\"/admin/book.php/?id=$row[book_id]\">$text_mark</a>";
	echo "<br>";
}
exit();