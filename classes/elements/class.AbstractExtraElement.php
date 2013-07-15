<?php
abstract class AbstractExtraElement extends AbstractElement{
	protected $row;
	public function setRow($row){
		$this->row=$row;
	}
	public function getRow(){
		return $this->row;
	}
	public abstract function postProcess();
}
?>