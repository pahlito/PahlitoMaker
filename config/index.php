<?php
include 'main.php';
$config=$setup_config->getConfig();
if(!empty($_POST)){
	$user_email=trim($_POST['email']);
	$user_pass=md5($_POST['pass']);
	if(Session::login($user_email, $user_pass)){
		$mensaje="welcome";
		header("Location: ./tables.php?message=$mensaje");
		exit;
	}else{
		$error="Datos incorrectos";
	}
}
if(Session::isAdmin()){
	header("Location: ./tables.php");
	exit;
}
$smarty=new Smarty;
$smarty->assign(array(
	'_post'=>$_POST,
	'theme'=>Config::getThemeURL()
));
if($error) $smarty->assign(array('error', $error));
$smarty->display(Config::getThemeDir().'config/login.tpl');
?>
