<?php
class Builder {
	private static $classes;
	public static function getInstanceOf($slug, $params){
		if(isset(self::$classes[$slug])&&file_exists(BUILDER_DIR.self::$classes[$slug].'.php')){
			require_once BUILDER_DIR.'class.AbstractBuilder.php';
			require_once BUILDER_DIR.self::$classes[$slug].'.php';
			return new self::$classes[$slug]($params);
		}else{
			trigger_error("Builder $slug doesn't exists.", E_USER_ERROR);
		}
		return NULL;
	}
	public static function registerBuilders(){
		$path=dirname(__FILE__);
		$dir=opendir($path);
		while(FALSE !== ($filename=readdir($dir))){
			if(preg_match('/^(?!class.)(\w*)(Builder).php$/', $filename, $result)){
				$class=$result[1].'Builder';
				$name=trim(strtolower($result[1]));
				self::registerClass($name, $class);				
			}
		}
	}
	public static function registerClass($slug, $class){
		if(isset(self::$classes[$slug])) trigger_error("Builder $slug ovewritten.", E_USER_WARNING);
		self::$classes[$slug]=$class;
	}
	public static function deregisterClass($slug){
		unset(self::$classes[$slug]);
	}
}
?>
