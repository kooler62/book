<?
include __DIR__ . '/bd.php';

function select($query='*',$from)
{
	$sql="SELECT $query FROM $from";
	$result=mysqli_query($db, $sql) or die(mysqli_error($db));
	$how=mysqli_num_rows($result);
	
	for ($i=0; $i < $how; $i++)
	{
		$myrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
		return $myrow;
}
/*

function select_from_where($query='*',$from,$where)
{
	$sql="SELECT $query FROM $value WHERE $where";
	$result=mysqli_query($db, $sql) or die(mysqli_error($db));
	$how=mysqli_num_rows($result);
	# code...
}
*/