<?php
include 'secure.php';
$config=$setup_config->getConfig();
if(isset($_POST['save'])&&$_GET['table']){
	unset($_POST['save']);
	$config['tables'][$_GET['table']]['description']=$_POST['description'];
	$config['tables'][$_GET['table']]['display']=(bool)$_POST['display'];
	unset($_POST['description']);
	unset($_POST['display']);
	foreach($_POST as $field=>$element){
		$config['tables'][$_GET['table']]['elements'][$field]=$element;
	}
	$setup_config->setConfig($config);
}
$tables=$config['tables'];
if(isset($_GET['table'])) $table=$tables[$_GET['table']];
$smarty->assign(array(
	'tables'=>$tables,
	'table'=>$table,
	'types'=>Element::getClasses()
));