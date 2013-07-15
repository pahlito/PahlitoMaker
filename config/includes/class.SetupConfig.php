<?php
class SetupConfig extends Config{
	public function setConfig($config){
		parent::saveBaseConfig($config);
	}
	public function getConfig(){
		return parent::$config;
	}
	public function getActions(){
		return Action::getActions();
	}
}
?>