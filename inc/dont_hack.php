<?
/**
*сделать режим string | id | page | signed
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