<?
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../functions.php';
//вытащим id из REFERER http://book/admin/book.php/?id= 31 символа
$book_id = substr($_SERVER[HTTP_REFERER],31);
$book_id = dont_hack($book_id,int);

//инсертим осовные понятия в книгу с выбраным айдишником

$ara=array('book_title'=>$_POST[title],'book_img'=>$_POST[img],'book_price'=>$_POST[price],'book_description'=>$_POST[text]);
sql_update_where('books',$ara,"book_id=$book_id");
/*
$select_sql = "UPDATE books SET 
book_title='".$_POST[title]."',
book_img='".$_POST[img]."',
book_price='".$_POST[price]."',
book_description='".$_POST[text]."'
WHERE book_id=$book_id";
$result = mysqli_query($db, $select_sql) or die(mysqli_error($db));
*/
#######################################################################
//не будем проверять как изменились данные в авторе и жанре, просто удалим и создадим заново
//удалим жанры
sql_del('book_genre', "book=$book_id");
//теперь удалим авторов 
sql_del('book_author', "book=$book_id");
//Создание
//проверим заполнены ли поля автора
if  (!empty($_POST[author]) ) {
	//проверим, есть ли запятые в поле автора
	if (strpos($_POST[author],',') === false) {
		//запятой нету->автор 1
		//проверим, есть ли такой автора в базе
		$aut = dont_hack($_POST[author]);
		$row_find_author = sql_fetch_where('author_id', 'authors', "author_name='$aut'");
		if ($row_find_author) {
			//автор есть берем его id $row_find_author[author_id]
			//закидываем в таблицу автор_книга айди книги
		author_one:
			$ara1=array('book'=>$book_id, 'author'=>$row_find_author[author_id]);
			sql_insert('book_author',$ara1);
			//вставляем автора			
		}else{
			//автора нет! 
			//нужно создать автора а для этого нужно получить значение инкремента
			$future_aut = get_id($db,authors);
			$ara2=array('author_id'=>$future_aut, 'author_name'=>$aut);
			sql_insert('authors',$ara2);
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
			$how_find_author = sql_how_where('author_id', 'authors', "author_name='$aut'");
			//если автор есть
			if ($how_find_author >=1) {
				$myrow = sql_fetch_where('author_id', 'authors', "author_name='$aut'");
				//автор есть,берем его id
				$author_id = $myrow[author_id];
			metka:
				//инсёртим автора и книгу в таблицу книга_автор
				$ara3=array('book'=>$book_id, 'author'=>$author_id);
				sql_insert('book_author',$ara3);
			}else{
				//если автора нет
				//создадим автора/возьмем его авто инкремент значение и кинем на метку
				$future_aut = get_id($db,authors);
				$ara4=array('author_id'=>$future_aut, 'author_name'=>$aut);
				sql_insert('authors',$ara4);	
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
		$row_find_genre = sql_fetch_where('genre_id', 'genres', "genre_name='$gen'");
		if ($row_find_genre) {
			//жанр есть берем его id $row_find_genre[genre_id]
			//закидываем в таблицу жанр_книга айди книги
		genre_one:
			$ara5=array('book'=>$book_id, 'genre'=>$row_find_genre[genre_id]);
			sql_insert('book_genre',$ara5);
		}else{
			//жанра нет!
			//нужно создать жанр а для этого нужно получить значение инкремента
			$future_gen = get_id($db,genres);
			$ara6=array('genre_id'=>$future_gen, 'genre_name'=>$gen);
			sql_insert('genres',$ara6);
			//создали, присваеваем автора и кидаем выше на метку
			$row_find_genre[genre_id]=$future_gen;
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
			//провери наличие жанра в базе
			$how_find_genre = sql_how_where('genre_id', 'genres', "genre_name='$gen'");
			//если жанр есть
			if ($how_find_genre >= 1) {
				//жанр есть
				//берем его id
				$genre_id = $myrow[genre_id];
			genre_metka:
				//инсёртим жанр и книгу в таблицу книга_жанр
				$ara7=array('book'=>$book_id, 'genre'=>$row_find_genre[genre_id]);
				sql_insert('book_genre',$ara7);
			}else{
				//если жанра нет
				//создадим жанр/возьмем его авто инкремент значение и кинем на метку
				$future_gen = get_id($db,genres);
				$ara8=array('genre_id'=>$future_gen, 'genre_name'=>$gen);
				sql_insert('genres',$ara8);
				//создали присваеваем жанр и кидаем выше на метку
				$row_find_genre[genre_id]=$future_gen;
				goto genre_metka;
			}
		}
	//все хорошо
	}
}
//посылаем назад
header("Location: $_SERVER[HTTP_REFERER]");