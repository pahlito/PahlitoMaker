<?php
class DynamicSelectElement extends AbstractElement{
	public function __construct($params){
		$this->name=$params['name'];
		$this->config=$params['config'];
		$this->type=$this->config['type'];
		$this->description=$this->config['description'];
		$this->options=$this->getOptions();
	}
	public function setValue($value){
		$this->value=$value;
	}
	public function getValue(){
		$post_value=RequestHandler::getPost($this->name, FALSE);
		if($this->config['required']){
			if($post_value&&!empty($post_value)){
				return $post_value;
			}elseif(!empty($this->value)){
				return $this->value;
			}else{
				return FALSE;
			}
		}else{
			if($post_value){
				return $post_value;
			}else{
				return $this->value;
			}
		}
	}
	private function getOptions(){
		$table_name=$this->config['options']['relation']['table'];
		$value_field=$this->config['options']['relation']['value_field'];
		$display_field=$this->config['options']['relation']['display_field'];
		$db=new DB;
		$query="SELECT DISTINCT $value_field 'value', $display_field 'description' FROM $table_name WHERE 1";
		$rows=$db->get_results($query);
		return $rows;
	}
	public function getDisplayValue(){		
		$table_name=$this->config['options']['relation']['table'];
		$value_field=$this->config['options']['relation']['value_field'];
		$display_field=$this->config['options']['relation']['display_field'];
		$value=$this->getValue();
		$db=new DB;
		$query="SELECT $display_field FROM $table_name WHERE $value_field='$value'";
		return $db->get_value($query);
	}
}
?>