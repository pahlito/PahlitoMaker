<?php
class Error404Action extends AbstractAction{
	private $menu;
	public static $name='404';
	public static $parameters=array();
	public function process(){
		if(Session::isValid()){				
			$this->menu=Builder::getInstanceOf('menu', array('action_name'=>'table'));
		}	
	}
	public function postProcess(){}
	public function getDisplayObject(){
		return is_object($this->menu)? array('menu'=> $this->menu->getDisplayObject()): array();
	}
}
?>