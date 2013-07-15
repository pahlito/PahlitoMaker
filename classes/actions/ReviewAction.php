<?php
class ReviewAction extends AbstractAction{
	private $menu;
	private $form;
	private $table_name;
	private $row;
	private $config;
	public static $name='review';
	public static $parameters=array('object', 'row');
	public function __construct(){ 
		$action_name=RequestHandler::getParameter('action', 'error404'); //FIXME: why
		$this->table_name=RequestHandler::getParameter('object', FALSE);
		$this->row=RequestHandler::getParameter('row', FALSE);
		if($this->row&&Config::userCan($action_name, $this->table_name)){
			$this->config=Config::getTableConfig($this->table_name);
			$this->form=Builder::getInstanceOf('form', array('action_name'=> $action_name, 'table_name'=> $this->table_name));
			if(is_object($this->form)){				
				$db=new DB;
				$primary_key=$this->config['primary_key'];
				$query="SELECT * FROM $this->table_name WHERE $primary_key='$this->row'";
				$row=$db->get_row($query);
				foreach($this->config['elements'] as $element_name => $element_config){
					$element=Element::getInstanceOf($element_config['type'], array('name'=>$element_name, 'config'=>$element_config));
					$element->setValue($row[$element_name]);
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
	public function postProcess(){}
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