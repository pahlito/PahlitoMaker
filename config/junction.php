<?php
//TODO: Esta hueá está mal
include 'main.php';
$smarty=new Smarty;
include 'control/junction.php';
$smarty->assign(array(
	'_get'=>$_GET,
	'theme'=>Config::getThemeURL()
));
$smarty->display(Config::getThemeDir().'config/junction.tpl');