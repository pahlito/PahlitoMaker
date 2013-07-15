<?php
include 'main.php'; 
$smarty=new Smarty;
include 'control/actions.php';
$smarty->assign(array(
	'_get'=>$_GET,
	'theme'=>Config::getThemeURL()
));
$smarty->display(Config::getThemeDir().'config/actions.tpl');