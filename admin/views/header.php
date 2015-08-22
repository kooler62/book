<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?=$title?> | Админ панель</title>
		<link rel="stylesheet" href="/style.css">
	</head>
	<body>
		<header>
			<ul>
				<li><a href="/admin/">главная</a></li>
				<li><a href="/admin/genre.php">жанры</a></li>
				<li><a href="/admin/author.php">авторы</a></li>
				<li><form action="/admin/"><input name="search" type="text" placeholder="Поиск"></form></li>
				<li>|</li>
				<li><a href="/admin/add_book.php">Добавить книгу</a></li>
				<li title="e-mail куда придет заказ, чтобы изменить зайдите в файл /inc/ad_mail.php"><?echo "$e_mail";?></li>
				<li><a href="/">выход</a></li>
			</ul>
		</header>