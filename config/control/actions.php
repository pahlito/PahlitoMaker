<?php
include 'secure.php';
$config=$setup_config->getConfig();
$db=new DB();
if(!empty($_POST)){ //TODO: validar.
	$group_id=$_GET['group'];
	$query="DELETE FROM {$db->prefix}access WHERE group_id=$group_id";
	$db->execute($query);
	$access="";
	foreach($_POST['access'] as $table_name=>$action){
		foreach($action as $action_name=>$ok){
			$access.=($access? ", ": "")."($group_id, '$table_name', '$action_name')";
		}
	}
	if($access){
		$query="INSERT INTO {$db->prefix}access (group_id, table_name, action_name) VALUES $access";
		$db->execute($query);
		$mensaje="Cambios guardados"; 
	}
}
$query="SELECT * FROM {$db->prefix}groups";
$groups=$db->get_results($query);
$groupCan=array();
if(isset($_GET['group'])&&$group_id=$_GET['group']){
	$query="SELECT table_name, action_name FROM {$db->prefix}access WHERE group_id=$group_id";
	$access=$db->get_results($query);
	foreach($access as $row){
		$groupCan[$row['table_name']][$row['action_name']]=1;
	}
	$tables=$config['tables'];
	$actions=$setup_config->getActions();
}
$smarty->assign(array(
	'groups'=>$groups,
	'tables'=>$tables,
	'actions'=>$actions,
	'groupCan'=>$groupCan,
	'mensaje'=>$mensaje,
	'error'=>$error
));