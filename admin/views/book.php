
<form action="/admin/book_edit.php" method="post">
<img src="<?=$book[book_img]?>">
Автор:<input class="inp_title" name="author" type="text" value="<?=$author?>"><br>
Жанр: <input class="inp_title" name="genre" type="text" value="<?=$genre?>"><br>
Изображение: <input class="inp_title" name="img" type="text" value="<?=$book[book_img]?>"><br>
Название: <input class="inp_title" name="title" type="text" value="<?=$book[book_title]?>"><br>
Цена: <input name="price" value="<?=$book[book_price]?>">грн.<br>
<textarea name="text"><?=$book[book_description]?></textarea><br>
<a href='/admin/delete.php'>удалить книгу</a>
<button>обновить</button>
</form>
<style>
header{border:1px grey solid;}body{margin:0 auto;width:928px;}
article{width:200px;overflow:hidden;height:350px;display:inline-block;
border:1px grey solid;margin:10px;border-radius:5px;padding:5px;}
article h2{font-size:15px;margin-top:1px;text-overflow: ellipsis;
overflow:hidden;white-space:nowrap;}article h3{font-size:12px;
text-overflow:ellipsis;overflow:hidden;white-space:nowrap;}
article button{position:relative;top:-20px;}article span{float: right;}
article img{position: relative;	top: -14px;	display: block;	width: 200px;}
img{float: right;width: 250px;}
</style>