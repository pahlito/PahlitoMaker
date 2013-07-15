<?php
class IndexAction extends AbstractAction{
	private $menu;
	public static $name='index';
	public static $parameters=array();
	public function process(){
		if(!Session::isValid()){			
			$loginURL=Action::getActionURL('login', array('return'=>Action::getActionURL('index')));
			RequestHandler::redirect($loginURL);
		}		
		$this->menu=Builder::getInstanceOf('menu', array('action_name'=>'table'));
	}
	public function postProcess(){
	}
	public function getDisplayObject(){
		$displayObject=array(
			'menu'=> $this->menu->getDisplayObject()
		);
		return $displayObject;
	}
}
?>