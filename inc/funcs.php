<?
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



/**
*	echo dont_hack($_GET[page]); 
*	echo dont_hack($_GET[page],int);
*	echo dont_hack($_GET[page],int,signed);
*/
function dont_hack($param, $type = 'string',$sign = 'unsigned'){
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
			return trim( abs( (int)$param ) );
		}
		else{
			return trim( (int)$param );
		}
	}
}














?>