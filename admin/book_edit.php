<?
include __DIR__ . '/../config.php';
include __DIR__ . '/inc/functions.php';
//вытащим id из REFERER http://book/admin/book.php/?id= 31 символа
$book_id = substr($_SERVER[HTTP_REFERER],31);
$book_id = dont_hack($book_id,int);

//инсертим осовные понятия в книгу с выбраным айдишником
$select_sql = "UPDATE books
SET 
book_title='".$_POST[title]."',
book_img='".$_POST[img]."',
book_price='".$_POST[price]."',
book_description='".$_POST[text]."'
WHERE book_id=$book_id";
$result = mysqli_query($db, $select_sql) or die(mysqli_error($db));

#######################################################################
//не будем проверять как изменились данные в авторе  и жанре, просто удалим и создадим заново
//удалим жанры
$select_sql2 = "DELETE FROM book_genre
WHERE book=$book_id";
$result2 = mysqli_query($db, $select_sql2) or die(mysqli_error($db));
//теперь удалим авторов 
$select_sql1 = "DELETE FROM book_author
WHERE book=$book_id";
$result1 = mysqli_query($db, $select_sql1) or die(mysqli_error($db));

//Создание
//проверим заполнены ли поля автора
if  (!empty($_POST[author]) ) {
	//проверим, есть ли запятые в поле автора
	if (strpos($_POST[author],',') === false) {
		//запятой нету->автор 1
		//проверим, есть ли такой автора в базе
		$aut = dont_hack($_POST[author]);
		//echo "$aut";
		$sql_find_author = "SELECT author_id FROM authors WHERE author_name='$aut'";
		$result_find_author = mysqli_query($db, $sql_find_author) or die(mysqli_error($db));		
		$row_find_author = mysqli_fetch_array($result_find_author, MYSQLI_ASSOC);
		if ($row_find_author) {
			//автор есть берем его id $row_find_author[author_id]
			//закидываем в таблицу автор_книга айди книги
		author_one:
			$add_aut = "INSERT INTO book_author (book, author)
			VALUES ('".$book_id."','".$row_find_author[author_id]."')";		
			$add_aut_result = mysqli_query($db, $add_aut) or die(mysqli_error($db));
			//вставляем автора			
		}else{
			//автора нет! 
			//нужно создать автора а для этого нужно получить значение инкремента
			$future_aut = get_id($db,authors);
			$aut_create ="INSERT INTO authors (author_id, author_name)
			VALUES ('".$future_aut."','".$aut."')";
			$aut_create_result = mysqli_query($db, $aut_create) or die(mysqli_error($db));
			//создали присваеваем автора и кидаем выше на метку
			$row_find_author[author_id]=$future_aut;
			goto author_one;
		}
	}else{
		//есть запятые->авторов несколько
		//теперь проверять и создавать автора нужно будет на каждой итерации
		//кинем авторов в масив
		$pieces_a = explode(",", $_POST[author]);
		//переберем масив чтобы убрать пуcтоты если есть
		foreach ($pieces_a as $key => $value) {
			$pieces_a[$key] = dont_hack($value);
		}
		//теперь умешьшим масив если были пустоты
		$pieces_a = array_diff($pieces_a, array(''));
		for ($i=0; $i < count($pieces_a); $i++) { 
			//вытаскиваем автора
			$aut=$pieces_a[$i];
			//провери наличие автора в базе
			$sql_find_author = "SELECT author_id FROM authors WHERE author_name='$aut'";
			$result_find_author = mysqli_query($db, $sql_find_author) or die(mysqli_error($db));
			$how_find_author = mysqli_num_rows($result_find_author);
			//если автор есть
			if ($how_find_author >=1) {
				$myrow = mysqli_fetch_array($result_find_author, MYSQLI_ASSOC);
				//автор есть,берем его id
				$author_id = $myrow[author_id];
			metka:
				//инсёртим автора и книгу в таблицу книга_автор
				$sql_insert_author = "INSERT INTO book_author (book,author) VALUES ('$book_id','$author_id')";
				$result_insert_author = mysqli_query($db, $sql_insert_author) or die(mysqli_error($db));
			}else{
				//если автора нет
				//создадим автора/возьмем его авто инкремент значение и кинем на метку
				$future_aut = get_id($db,authors);
				$aut_create = "INSERT INTO authors (author_id, author_name)
				VALUES ('".$future_aut."','".$aut."')";
				$aut_create_result=mysqli_query($db, $aut_create) or die(mysqli_error($db));
				$author_id = $future_aut;
				//переброс на проверку автора
				goto metka;
			}
		}
	//все хорошо
	}
}

//проверим заполнены ли поля жанра
if ( !empty($_POST[genre]) ) {

	//проверим, есть ли запятые в поле жанра
	if (strpos($_POST[genre],',') === false) {
		//запятой нету-> 1 жанр
		//проверим, есть ли такой жанр в базе
		$gen = dont_hack($_POST[genre]);
		$sql_find_genre = "SELECT genre_id FROM genres WHERE genre_name='$gen'";
		$result_find_genre = mysqli_query($db, $sql_find_genre) or die(mysqli_error($db));
		$row_find_genre = mysqli_fetch_array($result_find_genre, MYSQLI_ASSOC);
		if ($row_find_genre) {
			//жанр есть берем его id $row_find_genre[genre_id]
			//закидываем в таблицу жанр_книга айди книги
		genre_one:
			$add_gen = "INSERT INTO book_genre (book, genre)
			VALUES ('".$book_id."','".$row_find_genre[genre_id]."')";
			$add_gen_result=mysqli_query($db, $add_gen) or die(mysqli_error($db));
		}else{
			//жанра нет!
			//нужно создать жанр а для этого нужно получить значение инкремента
			$future_gen = get_id($db,genres);
			$gen_create = "INSERT INTO genres (genre_id, genre_name)
			VALUES ('".$future_gen."','".$gen."')";
			$gen_create_result=mysqli_query($db, $gen_create) or die(mysqli_error($db));
			//создали, присваеваем автора и кидаем выше на метку
			$row_find_author[genre_id]=$future_gen;
			goto genre_one;
		}
	}else{
		//есть запятые->жанров несколько
		//теперь проверять и создавать жанр нужно будет на каждой итерации
		//кинем жанры в масив
		$pieces_g = explode(",", $_POST[genre]);
		//переберем масив чтобы убрать пуcтоты если есть
		foreach ($pieces_g as $key => $value) {
			$pieces_g[$key] = dont_hack($value);
		}
		//теперь умешьшим масив если были пустоты
		$pieces_g = array_diff($pieces_g, array(''));
		for ($i=0; $i < count($pieces_g); $i++) { 
			//вытаскиваем жанр
			$gen = $pieces_g[$i];
			//провери наличие автора в базе
			$sql_find_genre = "SELECT genre_id FROM genres WHERE genre_name='$gen'";
			$result_find_genre = mysqli_query($db, $sql_find_genre) or die(mysqli_error($db));
			$how_find_genre = mysqli_num_rows($result_find_genre);
			//если жанр есть
			if ($how_find_genre >= 1) {
				$myrow = mysqli_fetch_array($result_find_genre, MYSQLI_ASSOC);
				//жанр есть
				//берем его id
				$genre_id = $myrow[genre_id];
			genre_metka:
				//инсёртим жанр и книгу в таблицу книга_жанр
				$sql_insert_genre = "INSERT INTO book_genre (book,genre) VALUES ('$book_id','$genre_id')";
				$result_insert_genre = mysqli_query($db, $sql_insert_genre) or die(mysqli_error($db));
			}else{
				//если жанра нет
				//создадим жанр/возьмем его авто инкремент значение и кинем на метку
				$future_gen = get_id($db,genres);
				$gen_create = "INSERT INTO genres (genre_id, genre_name)
				VALUES ('".$future_gen."','".$gen."')";
				$gen_create_result = mysqli_query($db, $gen_create) or die(mysqli_error($db));
				$genre_id = $future_gen;
				//переброс на проверку автора
				goto genre_metka;
			}
		}
	//все хорошо
	}
}
//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");