<?php
class InsertAction extends AbstractAction{
	private $menu;
	private $form;
	private $table_name;
	private $row;
	private $config;
	public static $name='insert';
	public static $parameters=array('object', 'row');
	public function __construct(){
		$action_name=RequestHandler::getParameter('action', 'error404'); //FIXME why?
		$this->table_name=RequestHandler::getParameter('object', FALSE);
		if(Config::userCan($action_name, $this->table_name)){
			$this->config=Config::getTableConfig($this->table_name);
			$this->form=Builder::getInstanceOf('form', array('action_name'=> $action_name, 'table_name'=> $this->table_name));
			if(is_object($this->form)){
				foreach($this->config['elements'] as $element_name => $element_config){
					$element=Element::getInstanceOf($element_config['type'], array('name'=>$element_name, 'config'=>$element_config));
					if(is_object($element)) $this->form->addElement($element);
				}
				foreach($this->config['extras'] as $element_name => $element_config){
					$element=Element::getInstanceOf($element_config['type'], array('name'=>$element_name, 'config'=>$element_config));
					if(is_object($element)) $this->form->addExtra($element);
				}
			}
		}else{
			if(Session::isValid()){
				RequestHandler::error404();
			}else{	
				$loginURL=Action::getActionURL('login', array('return'=>Action::getActionURL('insert', array('object'=>$this->table_name))));
				RequestHandler::redirect($loginURL);
			}
		}
	}
	public function process(){		
		if(!Session::isValid()){			
			$loginURL=Action::getActionURL('login', array('return'=>Action::getActionURL('insert', array('object'=>$this->table_name))));
			RequestHandler::redirect($loginURL);
		}		
		$this->menu=Builder::getInstanceOf('menu', array('action_name'=>'table'));
	}
	public function postProcess(){
		if(is_object($this->form)){
			$data=$this->form->getValues();
			if($data!=FALSE){
				$db=new DB; 
				if($db->insert($this->table_name, $data)){
					if($id=$db->insert_id){
						$this->row=$id;
					}else{
						$this->row=$data[$this->config['primary_key']];
					}						
					$this->form->saveExtra($this->row);
					$reviewURL=Action::getActionURL('review', array('object'=>$this->table_name, 'row'=>$this->row));
					RequestHandler::redirect($reviewURL);
				}
			}
		}
	}
	public function getDisplayObject(){
		$displayObject=array();
		if(is_object($this->menu)){
			$displayObject['menu']=$this->menu->getDisplayObject();
		}
		if(is_object($this->form)){
			$displayObject['form']=$this->form->getDisplayObject();
		}
		return $displayObject;
	}
	public function getCommunicationObject(){
		if(is_object($this->form)){
			return $this->form->getCommunicationObject();
		}
		return array();
	}
}
?>