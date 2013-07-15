<?php
abstract class AbstractBuilder{
	public $slug;
	public abstract function getDisplayObject();
	public abstract function getCommunicationObject();
}
?>