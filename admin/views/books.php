<section>
<?
//echo $books[][book_title];

/*

echo "<hr>";
echo "<pre>";
var_dump($books);


echo "<hr>";
*/
?>


<? foreach ($books as $item) :?>
<article><div class="book_title">
 <h2 title="<?=$item[book_title]?>"><a href="/book.php/?id=<?=$item[book_id];?>"><?=$item[book_title]?></a></h2> 
<div class="img_bg">
<a href="/book.php/?id=<?=$item[book_id];?>"><img src="<?=$item[book_img];?>"></a></div>
<div class="boto">

<h3><? foreach ($item[author] as $author) :?>
<a href="/author.php/?id=<?=$author[author_id]?>"><?=$author[author_name]?></a>
<? endforeach; ?></h3>


<a href="/book.php/?id=<?=$item[book_id];?>#order"><button><?=$item[book_price];?> грн.</button></a>
	</div>
</article>
<? endforeach; ?>


<?
/*
echo "<hr>";
echo "<pre>";
var_dump($books);
*/
?>





</section>