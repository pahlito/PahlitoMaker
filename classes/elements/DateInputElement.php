<?php
class DateInputElement  extends AbstractElement{
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
			if($post_value&&!$this->isDateTime($post_value)){
				return $post_value;
			}elseif(!$this->isDateTime($this->value)){
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
	private function isDateTime($value){
		return preg_match("/^\d{4}-[0-1]\d{1}-[0-3]\d{1}\s[0-2]\d{1}:[0-5]\d{1}:[0-5]\d{1}$/", $value);
	}
}
?>