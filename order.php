<?
include_once __DIR__ . '/functions.php';
include __DIR__ . '/views/header.php';
//проверка параметра Заказать (было ли нажатие)
if (isset($_POST[sub])) {
	// проверка адреса
	if (isset($_POST[addr]) && !empty($_POST[addr])) {
		// адрес есть, он не пустой
		$addr = dont_hack($_POST[addr]);
		//проверка имени
		if (isset($_POST[name]) && !empty($_POST[name])) {
			// имя есть
			$name = dont_hack($_POST[name]);
			// проверка количетва
			if (isset($_POST[cnt]) && !empty($_POST[cnt])) {
				// количество указано
				$cnt = dont_hack($_POST[cnt],int);
				// Всё ок, посылаем голубя
				include __DIR__ . '/config.php';
				//обрежем RЕFERER чтоб получить id книги http://book/book.php?id= 25 символа
				$book_id = substr($_SERVER[HTTP_REFERER],25);
				//опять защита
				$book_id = dont_hack($book_id,int);
				//вытащим из базы название
				$myrow = sql_fetch_where('book_title','books', "book_id=$book_id");
				$book = $myrow[book_title];
				$text = "Имя: $name. Адресс: $addr. Книга(id) $book($book_id). $cnt шт.";
				mail(MAIL, 'Новый заказ', $text);
				$message="Ваш заказ принят! Книга: $book($cnt шт.)"; 
			}else{$message='Вы не заполнили форму заказа!';}
		}else{$message='Вы не указали имя получателя!';}
	}else{$message='Вы не указали адресс доставки!';}
}
echo $message;
exit();