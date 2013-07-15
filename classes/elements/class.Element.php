<?php
class Element {
	private static $classes;
	public static function getInstanceOf($slug, $params){
		if(isset(self::$classes[$slug])&&file_exists(ELEMENT_DIR.self::$classes[$slug].'.php')){
			require_once ELEMENT_DIR.'class.AbstractElement.php';
			require_once ELEMENT_DIR.'class.AbstractExtraElement.php';
			require_once ELEMENT_DIR.self::$classes[$slug].'.php';
			return new self::$classes[$slug]($params);
		}else{
			trigger_error("Element $slug doesn't exists.", E_USER_ERROR);
		}
		return NULL;
	}
	public static function registerElements(){
		$path=dirname(__FILE__);
		$dir=opendir($path);
		while(FALSE !== ($filename=readdir($dir))){
			if(preg_match('/^(?!class.)(\w*)(Element).php$/', $filename, $result)){
				$class=$result[1].'Element';
				$name=trim(strtolower($result[1]));
				self::registerClass($name, $class);				
			}
		}
	}
	public static function registerClass($slug, $class){
		if(isset(self::$classes[$slug])) trigger_error("Element $slug ovewritten.", E_USER_WARNING);
		self::$classes[$slug]=$class;
	}
	public static function deregisterClass($slug){
		unset(self::$classes[$slug]);
	}
	public static function getClasses(){
		return self::$classes;
	}
}
?>