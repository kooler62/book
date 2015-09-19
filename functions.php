<?
/**
*	echo dont_hack($_GET[page]); срока(удаление пробелов и экранирование тегов)
*	echo dont_hack($_GET[page],int); значение от 0 до 9
*	echo dont_hack($_GET[page],int,signed); от -9 до 9
*/
function dont_hack($param, $type = 'string', $sign = 'unsigned'){
	//защита строки
	if ($type == 'string') {
		//убираем пробелы и экранируем теги
		return trim( htmlspecialchars( $param ) );
	}
	//защита числа
	else{
		//число без знака
		if ($sign == 'unsigned') {
			//убирем отрицательное
			//return trim( abs( (int)$param ) );
			return abs((int)trim($param));
		}
		else{
			return (int)trim($param);
		}
	}
}



function pagination($posts,$on_page='12',$mini_view=7,$delim=' ... ',$this_page='class="current_page"') {
	# ПОСТРАНИЧНАЯ НАВИГАЦИЯ
	/**
	* $posts - всего элементов
	* $on_page - элементов на одной странице
	* $mini_view - сколько отображать страниц в навигации минимально 5, непарное число!
	* $delim - разделитель
	* $this_page - можно прописать css класс для выделения текущей страницы
	* @author kooler62
	* @link https://gist.github.com/kooler62/f4342c8dbdf1f9426129
	* @version 11
	*/
		//защита гет параметра
	$page = abs( $_GET['page'] );
	$pages = intval( ($posts - 1) / $on_page) + 1;
	//если минивид меньше 5 присвоем 5
	if ( $mini_view < 5) { $mini_view = 5; }
	if ( $on_page == 0) { $on_page = 10; }
	if ( empty($page) || !isset($page) || $page == 0) {$page = 1;}
	if ( $page >= $pages) {$page = $pages;}
	if ( $posts <= $on_page ) {
		# постов хватит только на 1 страницу, ничего не делаем
	}
	else{	
		//если постов меньше минивида
		if ($pages<=$mini_view) {
			for ($i=1; $i < $page; $i++) { 
				echo '<a href="?page=' . $i . '">' . $i . '</a> ';
			}
			echo '<a '.$this_page.' href="?page=' . $page . '">' . $page . '</a> ';
			for ($i= ++$page; $i <= $pages; $i++) { 
				echo '<a href="?page=' . $i . '">' . $i . '</a> ';
			}
		}
		//если мы в начале
		elseif ($page == 1 || $page <= 2+( ($mini_view-3) / 2) ) {
			if ($pages <= $mini_view) {
				$cickl_end = $pages;
				for ($i = 1; $i <= $cickl_end; $i++) {
					echo '<a href="?page=' . $i . '">' . $i . '</a> ';
				}
			}
			else{
				$cickl_end = $mini_view-1;
			}
			//цикл от начала до текущей
			for ($i = 1; $i < $page; $i++) {
				echo '<a href="?page=' . $i . '">' . $i . '</a> ';
			}
			//избранная
			echo '<a '.$this_page.' href="?page=' . $page . '">' . $page . '</a> ';
			//цикл оттекущей до конца начала
			for ($i = ++$page; $i <= $cickl_end; $i++) {
				echo '<a href="?page=' . $i . '">' . $i . '</a> ';
			}
			echo $delim . '<a href="?page=' . $pages . '">' . $pages . '</a> ';
		}
		// если мы в конце
		elseif ($page >= $pages || $page >= $pages-1-( ($mini_view-3) / 2) ) {
			if ($pages <= $mini_view) {
				for ($i = 1; $i <= $pages; $i++) {
					echo '<a href="?page=' . $i . '">' . $i . '</a> ';
				}
			}
			else{
				echo '<a href="?page=1">1</a>' . $delim;
				$start = $pages - ($mini_view - 2);
				for ($i = $start; $i < $page; $i++) {
					echo '<a href="?page=' . $i . '">' . $i . '</a> ';
				}
				echo '<a '.$this_page.' href="?page=' . $page . '">' . $page . '</a> ';
				for ($i = ++$page; $i <= $pages; $i++) {
					echo '<a href="?page=' . $i . '">' . $i . '</a> ';
				}
			}
		}
		// если мы в серидине
		else{
			echo '<a href="?page=1">1</a>' . $delim;
			$z = ($mini_view - 3) / 2;
			$middle_start = $page - $z;
			$middle_end = $page + $z;
			for ($i = $middle_start; $i < $page; $i++) { 
				echo '<a href="?page=' . $i . '">' . $i . '</a> ';
			}
			echo '<a ' . $this_page . ' href="?page=' . $page . '">' . $page . '</a> ';
			for ($i = ++$page; $i < $middle_end+1; $i++) { 
				echo '<a href="?page=' . $i . '">' . $i . '</a> ';
			}
			echo $delim . '<a href="?page=' . $pages . '">' . $pages . '</a>';
		}
	}
}
//echo pagination(100);

//////////////////////////////////////////////////////////////////////////
#							MySQL SCRIPTS
/////////////////////////////////////////////////////////////////////////
/*
получить значение автоинкремента таблицы
*/
function get_id($db,$table){
	$sql = "SHOW TABLE STATUS LIKE '$table'";
	$result = mysqli_query( $db, $sql);
	$row    = mysqli_fetch_assoc($result);
	return $row[Auto_increment];
}
//echo get_id($db,books);

//подсчитать количество записей
function sql_how($select, $from){
	return select($select, $from, 'how_many');
}
function sql_how_result($result){
	return mysqli_num_rows($result);
}
	function sql_fetch_result($result){
		return mysqli_fetch_array($result, MYSQLI_ASSOC);
}

function sql_limit($select, $from, $limit){
	global $db;
	$sql = "SELECT $select FROM $from LIMIT $limit";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
	return $result;
}

function sql_how_where($select, $from, $where){
	return select_where($select, $from, $where, 'how_many');
}

function sql_how_end($select, $from, $end){
	return select_end($select, $from, 'how_many');
}

function sql_fetch($select, $from){
	global $db;
	$sql = "SELECT $select FROM $from";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
	return mysqli_fetch_array($result, MYSQLI_ASSOC);
}

function sql_fetch_where($select, $from, $where){
	return select_where($select, $from, $where, 'fetch');
}

function sql_del($table, $where){
	global $db;
	$sql = "DELETE FROM $table WHERE $where";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
}

function select($select, $from, $answer=''){
	global $db;
	if ($answer=='limit') {
		$sql = "SELECT $select FROM $from LIMIT $limit";
	}
	else{
		$sql = "SELECT $select FROM $from";
	}
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
	if ($answer == 'how_many') {
		return mysqli_num_rows($result);
	}
	if ($answer == 'fetch') {
		return mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	return $result;
}

function select_where($select, $from, $where, $answer=''){
	global $db;
		$sql = "SELECT $select FROM $from WHERE $where";
		$result = mysqli_query($db, $sql) or die(mysqli_error($db));
		if ($answer == 'how_many') {
			return mysqli_num_rows($result);
		}
		if ($answer == 'fetch') {
			return mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
		return $result;
}

function select_end($select, $from, $end, $answer=''){
	global $db;
		$sql = "SELECT $select FROM $from $end";
		$result = mysqli_query($db, $sql) or die(mysqli_error($db));
		if ($answer == 'how_many') {
			return mysqli_num_rows($result);
		}
		if ($answer == 'fetch') {
			return mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
		return $result;
}

function sql_insert_one($table, $field, $value){
	global $db;
	$sql = "INSERT INTO $table ($field) VALUES ('".$value."')";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
}

function sql_search($select,$from,$where,$search){
	global $db;
	$sql = "SELECT $select FROM $from WHERE MATCH($where) AGAINST('".$search."')";
	$result = mysqli_query($db,$sql)or die(mysqli_error($db));
	return $result;
}


function sql_insert($table, $object){
 	global $db;
        $columns = array();
        $values = array();
        foreach ($object as $key => $value) {
            $columns[] = '`' . $key . '`';
            if ($value === null) {
                $values[] = 'NULL';
            }
            else {
                $values[] = "'$value'";
            }
        }
        $columns_s = implode(',', $columns);
        $values_s = implode(',', $values);
        $sql = "INSERT INTO {$table} ({$columns_s}) VALUES ({$values_s})";
		$result = mysqli_query($db, $sql) or die(mysqli_error($db));
}

function sql_update_where($table, $object,$where){
 	global $db;
        $columns = array();
       // $values = array();
        foreach ($object as $key => $value) {
        	if ($value === null || isset($value) || $value='') {
                $values[] = 'NULL';
            }
            $columns[] =  "$key='$value'";
        }
        $columns_s = implode(',', $columns);
        $sql = "UPDATE  $table SET $columns_s WHERE $where";
		$result = mysqli_query($db, $sql) or die(mysqli_error($db));
}