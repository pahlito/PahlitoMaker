<?php
class MenuBuilder extends AbstractBuilder{
	private $action_name;
	public function __construct($params){
		$action_name=$params['action_name'];
		$this->slug='menu';	
		$this->action_name=$action_name;	
	} 
	public function getDisplayObject(){
		$tables=Config::getTablesConfig();
		$list=array();
		foreach($tables as $table_name=>$config){
			if(Config::userCan($this->action_name, $table_name)&&$config['display']){
				$list[]=array(
					'description'=> $config['description'],
					'url'=>Action::getActionURL($this->action_name, array('object'=>$table_name))
				);
			}
		}
		return $list;
	}
	public function getCommunicationObject(){
	}
}
?>