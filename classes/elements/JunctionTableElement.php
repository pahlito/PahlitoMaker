<?php
class JunctionTableElement extends AbstractExtraElement{ //TODO: hacer todo realmente
	private $table_name;
	public function __construct($params){
		$this->table_name=RequestHandler::getParameter('table_name', FALSE);
		$this->row=RequestHandler::getParameter('row', 0);
		$this->
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
	public function postProcess(){
		if(is_null($this->row)) return FALSE;
		$db=new DB;
		$junction_table=$this->name;	
		$primary_key=$this->options['primary_key'];
		$display_key=$this->options['display_key'];
		$db->delete($junction_table, array($primary_key=>$this->row));
		echo $db->error;
		$values="";
		foreach($_POST[$junction_table] as $value){
			$values.=($values? ', ': '')."('$this->row', '$value')";
		}
		$query="INSERT INTO $junction_table ($primary_key, $display_key) VALUES $values";
		return $db->execute($query);
	}
	private function getOptions(){
		$junction_table=$this->name;
		$primary_key=$this->options['primary_key'];
		$display_table=$this->options['display_table'];
		$display_key=$this->options['display_key'];
		$display_field=$this->options['display_field'];
		$query=	"SELECT a.$display_key, a.$display_field ".(is_null($this->row)? "": ", b.$display_key 'saved'")." FROM $display_table a ".
				(is_null($this->row)? "": "LEFT JOIN $junction_table b ON (a.$display_key=b.$display_key AND b.$primary_key=$this->row)");
		$db=new DB;
		$rows=$db->get_results($query);
		return $rows;
	}
}
?>