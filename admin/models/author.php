<?
include __DIR__ . '/bd.php';
function author_info($id)
{
	$select="SELECT * FROM authors WHERE author_id=$id";
	$result=mysqli_query($db, $select) or die(mysqli_error($db));
	$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
	return $myrow[author_name];
}