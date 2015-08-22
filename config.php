<?
//конфиги базы
define('DB_HOST', 'book');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'book');

// e-mail администратора или того кто принимает заказы
define('MAIL', 'info@liveandlearn.com.ua');


$db = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);