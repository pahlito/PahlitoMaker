<?php
$config=$setup_config->getConfig();
if($_GET['table']&&$_GET['junction_table']){
	if(!empty($_POST)){
		$_POST['junction_table']=$_GET['junction_table'];
		$config['tables'][$_GET['table']]['extras'][$_POST['junction_table']]=$_POST;
		$setup_config->setConfig($config);
	}
	$options=$config['tables'][$_GET['table']]['extras'][$_GET['junction_table']]['options'];	
	$description=$config['tables'][$_GET['table']]['extras'][$_GET['junction_table']]['description'];
}
$smarty->assign(array(
	'config'=>$config,
	'options'=>$options,
	'description'=>$description
));
?>