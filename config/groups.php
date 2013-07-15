<?php
include 'main.php'; 
$smarty=new Smarty;
include 'control/groups.php';
$smarty->assign(array(
	'_get'=>$_GET,
	'theme'=>Config::getThemeURL()
));
$smarty->display(Config::getThemeDir().'config/groups.tpl');