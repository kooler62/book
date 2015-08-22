<?
  function translit($str) {
    $rus = array(',','?','!','–',' ','А', 'Б', 'В', 'Г', 'Д', 'Е','Є', 'Ё', 'Ж', 'З', 'И','І','Ї', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 
    	'а', 'б', 'в', 'г', 'д', 'е', 'є', 'ё', 'ж', 'з', 'и','і','ї', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('','','','-','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'E', 'Gh', 'Z', 'I','I','Yi', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 
    	'a', 'b', 'v', 'g', 'd', 'e', 'e', 'e', 'gh', 'z', 'i','i','yi', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
  }
  //приводим к нижнему регистру
  //echo mb_strtolower( translit("Притча про кривду та картоплину"));