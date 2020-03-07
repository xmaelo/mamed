<?php	
require_once ('vendor/autoload.php');
use \Dejurin\GoogleTranslateForFree;

$source = 'en';
$target = 'ru';
$attempts = 5;
$text = 'Hello';

$tr = new GoogleTranslateForFree();
$result = $tr->translate($source, $target, $text, $attempts);

var_dump($result); 

/* 
	string(24) "Здравствуйте" 
*/
	
 ?>