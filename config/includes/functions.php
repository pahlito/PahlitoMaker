<?php
function formatedName($name){
	$list=array();
	$words=explode("_", $name);
	foreach($words as $word) $list[]=ucfirst($word);
	return implode(" ", $list);
}
function passGenerator($len){
	$pass='';
	$letras =	"abcdefghijklmnopqrstuvwxyz".
				"ABCDEFGHIJKLMNOPQRSTUVWXYZ".
				"1234567890";
	while(strlen($pass)>$len){
		$pass.=$letras[rand(0, 62)];
	}	
	return $pass;	
}
?>