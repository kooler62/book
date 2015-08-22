<?
include __DIR__ . '/../config.php';
//подключаем хедер
include __DIR__ . '/../inc/ad_mail.php';
$title='Добавить книгу';
include __DIR__ . '/views/header.php';
?>
<img src="">
<form action="/admin/inc/add_book_confirm.php" method="post">
Изображение: <input class="inp_title" name="img" type="text" value="" placeholder="путь к изображению"><br>
Название: <input class="inp_title" name="title" type="text" value="" placeholder="название"><br>
Автор: <input class="inp_title" name="author" type="text" value=""><br>
Жанр: <input class="inp_title" name="genre" type="text" value=""><br>
Цена: <input name="price" value="">грн.<br>
<textarea name="text"></textarea><br>
<button>добавить</button>
</form>
<style>
header{border: 1px grey solid;}body{margin:0 auto;	width: 928px;}
article{width: 200px;overflow: hidden;height: 350px;display: inline-block;
border: 1px grey solid;margin: 10px;border-radius: 5px;padding: 5px;}
article h2{font-size: 15px;margin-top: 1px;	text-overflow: ellipsis;
overflow: hidden; white-space: nowrap;}article h3{font-size: 12px;
text-overflow: ellipsis;overflow: hidden; white-space: nowrap;}
article button{position: relative;top: -20px;}article span{float: right;}
article img{position: relative;top: -14px;display: block;width: 200px;}
img{float: right;}
</style>