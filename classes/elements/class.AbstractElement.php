<?php
abstract class AbstractElement{
	public $name;
	public $type;
	public $description;
	public $value;
	public $error;
	public $options;
	public $multiple=FALSE;
	
	protected $config;
	
	public abstract function setValue($value);
	public abstract function getValue();
	public function getDisplayValue(){return $this->getValue();}
}
?>