<?php
include 'secure.php';
$config=$setup_config->getConfig();
$db=new DB();
if(isset($_POST['group_name'])){
	$group_name=trim($_POST['group_name']);
	if(!empty($group_name)){
		if(is_numeric($_POST['group_id'])&&$group_id=trim($_POST['group_id'])){
			$db->update($db->prefix."groups", array('group_name'=>$group_name), array('group_id'=>$_POST['group_id']));
		}else{
			$db->insert($db->prefix."groups", array('group_name'=>$group_name));
			$group_id=$db->insert_id;
		}
		$mensaje=$db->error;
	}
}
unset($_POST);
if(isset($_GET['group'])&&is_numeric($_GET['group'])){
	$group_id=trim($_GET['group']);
	$query="SELECT group_name FROM ".$db->prefix."groups WHERE group_id=$group_id";
	$group_name=$db->get_value($query);
	$mensaje=$db->error;
}
if(isset($_GET['delete'])&&is_numeric($_GET['delete'])){
	$group_id=trim($_GET['delete']);
	$query="SELECT COUNT(user_id) FROM ".$db->prefix."users WHERE group_id=$group_id";
	if(!$db->get_value($query)){
		$query="DELETE FROM ".$db->prefix."groups WHERE group_id=$group_id";
		$db->execute($query);
		$mensaje=$db->error;
		header('Location: ./groups.php');
	}
}
$query=	"SELECT a.*, COUNT(b.user_id) group_users ".
		"FROM ".$db->prefix."groups a LEFT JOIN ".$db->prefix. "users b USING (group_id) ".
		"GROUP BY a.group_id";
$groups=$db->get_results($query);
$smarty->assign(array(
	'group_id'=>$group_id,
	'group_name'=>$group_name,
	'groups'=>$groups
));