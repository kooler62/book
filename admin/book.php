<?
include __DIR__ . '/../config.php';
//подключаем хедер
include __DIR__ . '/../inc/ad_mail.php';
$title = 'Книга';
include __DIR__ . '/views/header.php';

$id = htmlentities(trim($_GET[id]))*1;

$select_sql = "SELECT * FROM books WHERE book_id=$id";
$result = mysqli_query($db, $select_sql) or die('404');
$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
echo '<img src="';
echo $myrow[book_img];
echo '"><form action="/admin/book_edit.php" method="post">';
echo "Изображение: <input class=\"inp_title\" name=\"img\" type=\"text\" value=\"$myrow[book_img]\"><br>";
echo "Название: <input class=\"inp_title\" name=\"title\" type=\"text\" value=\"$myrow[book_title]\">";

echo "<br>";
//ищем авторов по айди этой книги
$select_sql_2="SELECT author FROM book_author WHERE book=$id";
$result_2=mysqli_query($db, $select_sql_2) or die(mysqli_error($db));
//сколько авторов
$how_2=mysqli_num_rows($result_2);

	//если авторов больше одного используем цикл
if (!isset($how_2) or $how_2==0) {
	echo 'Автор: <input class="inp_title" name="author" type="text" value="">';
	//echo nothing
}
else{
// если есть 1 автор
	if ($how_2 == 1) {
		$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
		$select_sql_3 = "SELECT * FROM authors WHERE author_id=$myrow_2[author]";//.$myrow[book_author];
		$result_3 = mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
		$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
	echo "Автор: <input class=\"inp_title\" name=\"author\" type=\"text\" value=\"$myrow_3[author_name]\">";
}
else{
	// если авторов больше одного
	echo "Автор: <input class=\"inp_title\" name=\"author\" type=\"text\" value=\"";
		for ($a=1; $a <= $how_2; $a++) { 
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
				$select_sql_3 = "SELECT * FROM authors WHERE author_id=$myrow_2[author]";//.$myrow[book_author];
				$result_3 = mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
				$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
				//знаки пунктуации
				if($a == $how_2){
					echo "$myrow_3[author_name]";
				}
				else{echo "$myrow_3[author_name], ";}
		}echo "\">";
	}
}
echo "<br>";
//ищем жанры по айди этой книги
$select_sql_2 = "SELECT genre FROM book_genre WHERE book=$id";//.$myrow[book_genre];
	$result_2 = mysqli_query($db, $select_sql_2) or die(mysqli_error($db));
	//сколько жанров
	$how_2 = mysqli_num_rows($result_2);

	//если жанров больше одного используем цикл
if ( !isset($how_2) or $how_2==0 ) {
	echo 'Жанр: <input class="inp_title" name="genre" type="text" value="">';
	//echo nothing
}
else{
// если есть 1 жанр
	if ($how_2 == 1) {
		$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
		$select_sql_3 = "SELECT * FROM genres WHERE genre_id=$myrow_2[genre]";
		$result_3 = mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
		$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
	echo "Жанр: <input class=\"inp_title\" name=\"genre\" type=\"text\" value=\"$myrow_3[genre_name]\">";
}
else{
	// если жанров больше одного
	echo "Жанр: <input class=\"inp_title\" name=\"genre\" type=\"text\" value=\"";
		for ($a=1; $a <= $how_2; $a++) { 
			$myrow_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
				$select_sql_3 = "SELECT * FROM genres WHERE genre_id=$myrow_2[genre]";
				$result_3 = mysqli_query($db, $select_sql_3) or die(mysqli_error($db));
				$myrow_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
				if($a == $how_2){
					echo "$myrow_3[genre_name]";
				}
				else{echo "$myrow_3[genre_name], ";}
		}echo "\">";
	}
}
echo "<br>Цена: <input name=\"price\" value=\"$myrow[book_price]\">грн.";
echo "<br>";
echo "<textarea name=\"text\">$myrow[book_description]</textarea>";
echo "<br><a href='/admin/delete.php'>удалить книгу</a> ";
echo "<button>обновить</button>";
echo "</form>";
?>
<style>
header{border:1px grey solid;}body{margin:0 auto;width:928px;}
article{width:200px;overflow:hidden;height:350px;display:inline-block;
border:1px grey solid;margin:10px;border-radius:5px;padding:5px;}
article h2{font-size:15px;margin-top:1px;text-overflow: ellipsis;
overflow:hidden;white-space:nowrap;}article h3{font-size:12px;
text-overflow:ellipsis;overflow:hidden;white-space:nowrap;}
article button{position:relative;top:-20px;}article span{float: right;}
article img{position: relative;	top: -14px;	display: block;	width: 200px;}
img{float: right;}
</style>