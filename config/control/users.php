<?php 
$config=$setup_config->getConfig();
$db=new DB();
$query="SELECT * FROM ".$db->prefix."groups";
$groups=$db->get_results($query);
if(!empty($_POST)){
	if(filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) $user_email=trim($_POST['user_email']);
	else $error.="<p>Debe ingresar un email válido";
	if(is_numeric($_POST['group_id'])) $group_id=$_POST['group_id'];
	else $error.="<p>Debe asignar un grupo</p>";
	if(!$error){
		if(is_numeric($_POST['user_id'])&&$user_id=$_POST['user_id']){
			$data=array(
				'user_email' => $user_email,
				'group_id' => $group_id
			);
			if(!empty($_POST['user_pass'])) $data['user_pass']=md5($_POST['user_pass']);
			$db->update(
				$db->prefix."users", 
				$data, 
				array('user_id'=>$user_id)
			);
		}else{
			if(empty($_POST['user_pass'])) $user_pass=passGenerator(6);
			else $user_pass=md5($_POST['user_pass']);
			$db->insert(
				$db->prefix."users",
				array(
					'user_email'=>$user_email,
					'user_pass'=>md5($user_pass),
					'group_id'=>$group_id
				)
			);
			//TODO: enviar email con la contrase�a
		}
	}
}
if(is_numeric($_GET['delete'])&&($user_id=$_GET['delete'])&&($user_id!=Session::getSessionData('user_id'))){
	$db->delete(
		$db->prefix."users",
		array('user_id'=>$user_id) 
	);
	header("Location: ./users.php");
}
if(is_numeric($_GET['user'])||isset($user_id)){
	$user_id=isset($user_id)? $user_id: $_GET['user_id'];
	$query="SELECT * FROM ".$db->prefix."users WHERE user_id=".$_GET['user'];
	$user=$db->get_row($query);
	$group_id=$user['group_id'];
	$smarty->assign(array('user'=>$user));
}
if(isset($group_id)||is_numeric($_GET['group'])){
	$group_id=isset($group_id)? $group_id:$_GET['group'];
	$query="SELECT user_id, user_email FROM ".$db->prefix."users WHERE group_id=$group_id";
	$users=$db->get_results($query);
	$smarty->assign(array('users'=>$users));
}
$smarty->assign(array(
	'groups'=>$groups
));