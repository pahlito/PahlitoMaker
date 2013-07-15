<?php
class TableAction extends AbstractAction{
	private $menu;
	private $table_name;
	private $fields;
	private $rows;
	public static $name='table';
	public static $parameters=array('object');
	public function TableAction(){
		$this->table_name=RequestHandler::getParameter('object', FALSE);
	}
	public function process(){
		if(!Session::isValid()){			
			$loginURL=Action::getActionURL('login', array('return'=>Action::getActionURL('table')));
			RequestHandler::redirect($loginURL);
		}		
		if(!empty($this->table_name)&&Config::getTableConfig($this->table_name)){
			$this->menu=Builder::getInstanceOf('menu', array('action_name'=>'table'));
		}else{
			RequestHandler::error404();
		}		
		if(file_exists(Config::getThemeDir().'css/table.css')){//TODO: Cambiar al RequestHandler
			RequestHandler::addStyle('login', Config::getThemeURL().'css/table.css');
		}
		if(file_exists(Config::getThemeDir().'js/table.js')){//TODO: Cambiar al RequestHandler
			RequestHandler::addScript('login', Config::getThemeDir().'js/table.js');
		}
	}
	public function postProcess(){
	}
	public function getDisplayObject(){
		$links=array();		
		$config=Config::getTableConfig($this->table_name);
		if(Config::userCan('insert', $this->table_name)){
			$links[]=array(
				'action'=> 'insert',
				'href'=> Action::getActionURL('insert', array('object'=>$this->table_name)),
				'description'=>  'Agregar a '.$config['description']
			);
		}
		$select="";
		$this->fields=array();
		$this->rows=array();
		foreach($config['elements'] as $field=>$data){
			if($data['display']){
				$select.=($select?", ":"").$field;
				$this->fields[]=array('id'=>$field, 'description'=>$data['description']);
			}
		}
		if($select){
			$db=new DB();
			$query="SELECT $select FROM $this->table_name";
			$rows=$db->get_results($query);
			foreach($rows as $row){
				foreach($row as $field=>$value){
					if($relation=$config['elements'][$field]['options']['relation']){
						$query="SELECT ".$relation['display_field']." FROM ".$relation['table']." WHERE ".$relation['value_field']." = '$value'";
						$value=$db->get_value($query);
						$row[$field]=$value;
					}
				}
				$row_links=array();
				if(Config::userCan('review', $this->table_name)){
					$reviewURL=Action::getActionURL('review', array('object'=>$this->table_name, 'row'=>$row[$config['primary_key']]));
					$row_links[]=array(
						'action'=> 'review',
						'href'=> $reviewURL,
						'description'=>''
					);
				}
				if(Config::userCan('update', $this->table_name)){
					$updateURL=Action::getActionURL('update', array('object'=>$this->table_name, 'row'=>$row[$config['primary_key']]));
					$row_links[]=array(
						'action'=> 'update',
						'href'=> $updateURL,
						'description'=>''
					);
				}
				if(Config::userCan('delete', $this->table_name)){
					$deleteURL=Action::getActionURL('delete', array('object'=>$this->table_name, 'row'=>$row[$config['primary_key']]));
					$row_links[]=array(
						'action'=> 'delete',
						'href'=> $deleteURL,
						'description'=>''
					);
				}
				$this->rows[]=array('id'=>$row[$config['primary_key']], 'values'=>$row, 'links'=>$row_links);				
			}
		}
		return array('fields'=>$this->fields, 'rows'=>$this->rows, 'menu'=> $this->menu->getDisplayObject(), 'links'=>$links);
	}
}
?>