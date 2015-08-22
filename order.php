<?
include __DIR__ . '/inc/header.php';
//проверка параметра Заказать (было ли нажатие)
if (isset($_POST['sub'])) {
	// проверка адреса
	if (isset($_POST['addr']) && !empty($_POST['addr'])) {
		// адрес есть, он не пустой
		$addr = htmlentities(trim($_POST[addr]));
		//проверка имени
		if (isset($_POST['name']) && !empty($_POST['name'])) {
			// имя есть
			$name = htmlentities(trim($_POST[name]));
			// проверка количетва
			if (isset($_POST['cnt']) && !empty($_POST['cnt'])) {
				// количество указано
				$cnt = htmlentities(trim($_POST[cnt]))*1;
				// Всё ок, посылаем голубя
				include __DIR__ . '/config.php';
				//обрежем RЕFERER чтоб получить id книги http://book/book.php?id= 24 символа
				$book_id = substr($_SERVER[HTTP_REFERER],24);
				//опять защита
				$book_id = htmlentities(trim($book_id))*1;
				//вытащим из базы название
				$select_sql = "SELECT book_title FROM books WHERE book_id=$book_id";
				$result = mysqli_query($db, $select_sql) or die(mysqli_error($db));
				$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$book = $myrow[book_title];
				$text = "Имя: $name. Адресс: $addr. Книга(id) $book($book_id). $cnt шт.";
				mail(MAIL, 'Новый заказ', $text);
				echo "Ваш заказ принят!";
			}else{echo "Вы не заполнили форму заказа!";}
		}else{echo "Вы не указали имя получателя!";}
	}else{echo "Вы не указали адресс доставки!";}
}
exit();