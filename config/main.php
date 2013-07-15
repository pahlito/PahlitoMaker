<?php
//ini_set('display_errors', 1);
include_once '../main.php';
if(isset($_REQUEST['logout'])){
	Session::closeSession();
	header('Location: ./');
}
require_once 'includes/class.SetupConfig.php';
require_once 'includes/functions.php';
$setup_config=new SetupConfig();
?>