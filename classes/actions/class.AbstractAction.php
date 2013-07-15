<?php
abstract class AbstractAction{
	public abstract function process();
	public abstract function postProcess();
	public abstract function getDisplayObject(); 
} 
?>