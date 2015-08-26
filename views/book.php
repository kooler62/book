<img class="img_bag" src="<?=$book[book_img]?>">
<h2>
<?php foreach ($book[book_genre][genre_name] as  $key => $value) :?>
<a href="/genre.php/?id=<?=$key?>"><?=$value;?></a> 
<?php endforeach; ?>
</h2>
<h1><?=$book[book_title]?></h1>
<h3>
<?php foreach ($book[book_author][author_name] as  $key => $value) :?>
<a href="/author.php/?id=<?=$key?>"><?=$value;?></a> 
<?php endforeach; ?>
</h3>
<?=$book[book_price]?>грн.<br>
<p><?=$book[book_description]?></p>