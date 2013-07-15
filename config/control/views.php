<?php
$config=$setup_config->getConfig();
if(isset($_POST['save'])&&is_array($_POST['fields'])){
	unset($_POST['save']);
	$config['tables'][$_GET['table']]['views'][$_GET['view_table']]=$_POST;
	$setup_config->setConfig($config);
}
$view=$config['tables'][$_GET['table']]['views'][$_GET['view_table']];
if(!is_array($view['fields'])) $view['fields']=array();
$smarty->assign(array(
	'view'=>$view,
	'config'=>$config
));
