<section class="genres">
<?=$start_message ?>


<?

if (isset($message)) {
	echo "$message";
	
}
?>



<? if (isset($book)): ?>
	<? foreach($book as $item): ?>
		<h2><a href="/book.php?id=<?=$item[book_id]?>"><?=$item[book_title]?></a></h2>
	<? endforeach; ?>
<? endif; ?>



<? if (isset($genre)): ?>
<?array_splice($genre, 12);?>
	<? foreach($genre as $item): ?>
		
		<a href="/genre.php?id=<?=$item[genre_id]?>"><?=$item[genre_name]?></a>
		<a title="удалить" style="color:red" class="del_a" href="/admin/inc/del_genre.php/?id=<?=$item[genre_id]?>">х</a><br>
	<? endforeach; ?>
<? endif; ?>




</section>