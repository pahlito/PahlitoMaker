<?php
class NumericInputElement extends AbstractElement{
	public function __construct($params){
		$this->name=$params['name'];
		$this->config=$params['config'];
		$this->type=$this->config['type'];
		$this->description=$this->config['description'];
	}
	public function setValue($value){
		$this->value=$value;
	}
	public function getValue(){
		$post_value=RequestHandler::getPost($this->name, FALSE);
		if($this->config['required']){
			if($post_value&&!is_numeric($post_value)){
				return $post_value;
			}elseif(!is_numeric($this->value)){
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
}
?>