<section class="authors">
<?=$start_message ?>


<?


	echo $message;
	

?>



<? if (isset($book)): ?>
	<? foreach($book as $item): ?>
		<h2><a href="/book.php?id=<?=$item[book_id]?>"><?=$item[book_title]?></a></h2>
	<? endforeach; ?>
<? endif; ?>



<? if (isset($author)): ?>
<?array_splice($author, 12);?>
	<? foreach($author as $item): ?>
		
		<a href="/author.php?id=<?=$item[author_id]?>"><?=$item[author_name]?></a>
		<a title="удалить" style="color:red" class="del_a" href="/admin/inc/del_author.php/?id=<?=$item[author_id]?>">х</a><br>
	<? endforeach; ?>
<? endif; ?>






</section>