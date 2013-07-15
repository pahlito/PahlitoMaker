<?php
class FormBuilder extends AbstractBuilder{
	private $action_name;
	private $config;
	private $elements;
	private $extras;
	public function __construct($params){	
		$this->action_name=$params['action_name'];
		$this->config=Config::getTableConfig($params['table_name']);
		$elements=$params['elements'];
		if(is_array($elements)) $this->elements=$elements;
		else $this->elements=array();
		$this->extras=array();
	}
	public function getDisplayObject(){
		$elements=array_merge(array(), $this->elements, $this->extras);
		$displayObject=array(
			'description'=> $this->config['description'],
			'elements'=> $elements,
			'action'=>$this->action_name			
		);
		return $displayObject;
	}
	public function getCommunicationObject(){
		return $this->getDisplayObject();
	}
	
	public function addElement($element){
		$this->elements[]=$element;
	}
	public function addExtra($extra){
		$this->extras[]=$extra;
	}
	public function saveExtra($row=NULL){
		echo "SAVE $row";
		foreach($this->extras as $extra){
			if(!is_null($row)) $extra->setRow($row);
			$extra->postProcess();
		}
	}
	public function getValues(){
		$values=array();
		foreach($this->elements as $element){
			$value=$element->getValue();
			if($value===FALSE) return FALSE;
			if(is_null($value)) continue;
			$values[$element->name]=$value;
		}
		return $values;
	}
}
?>