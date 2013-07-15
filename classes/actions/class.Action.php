<?php
class Action {
	private static $classes;
	public static function getInstanceOf($action_name){
		if(isset(self::$classes[$action_name])&&file_exists(ACTION_DIR.self::$classes[$action_name].'.php')){
			require_once ACTION_DIR.'class.AbstractAction.php';
			require_once ACTION_DIR.self::$classes[$action_name].'.php';
			if(file_exists(Config::getThemeDir()."css/$action_name.css")){
				RequestHandler::addStyle($action_name, Config::getThemeURL()."css/$action_name.css");
			}
			if(file_exists(Config::getThemeDir()."js/$action_name.js")){
				RequestHandler::addScript($action_name, Config::getThemeDir()."js/$action_name.js");
			}
			return new self::$classes[$action_name]();
		}else{
			trigger_error("Action $slug doesn't exists.", E_USER_ERROR);
		}
		return NULL;
	}
	public static function registerActions(){
		$path=dirname(__FILE__);
		$dir=opendir($path);
		while(FALSE !== ($filename=readdir($dir))){
			if(preg_match('/^(?!class.)(\w*)(Action).php$/', $filename, $result)){
				$class=$result[1].'Action';
				$name=trim(strtolower($result[1]));
				self::registerAction($name, $class);				
			}
		}
	}
	public static function registerAction($action_name, $class){
		if(isset(self::$classes[$action_name])) trigger_error("Action $action_name ovewritten.", E_USER_WARNING);
		self::$classes[$action_name]=$class;
	}
	public static function deregisterAction($action_name){
		unset(self::$classes[$action_name]);
	}	
	public static function getActions(){
		return self::$classes;
	}
	public static function getActionClass($action_name){
		if(array_key_exists($action_name, self::$classes)){
			return self::$classes[$action_name];
		}else{
			return FALSE;
		}
	}
	public static function getActionParameters($action_name){ //TODO: cambiar al action itself
		$class=self::getActionClass($action_name);
		if(class_exists($class)){
			return property_exists($class, 'parameters')? $class::$parameters: FALSE;
		}elseif($class){
			if(file_exists(ACTION_DIR.self::$classes[$action_name].'.php')){
				require_once ACTION_DIR.'class.AbstractAction.php';
				require_once ACTION_DIR.self::$classes[$action_name].'.php';
				return class_exists($class)&&property_exists($class, 'parameters')? $class::$parameters: FALSE;
			}
		}
		return FALSE;
	}
	public static function getActionURL($action_name, $request=array()){
		$parameters=self::getActionParameters($action_name);
		$query=array();
		if(is_array($parameters)&&is_array($request)){
			foreach($parameters as $parameter){
				if(array_key_exists($parameter, $request)) $query[$parameter]=$request[$parameter]; 
			}
		}
		if($token=Session::getSessionData('token')) $query['token']=$token;
		return Config::getBaseURL().'/'.$action_name.".".RequestHandler::getParameter('format', 'html').(count($query)? '?'.http_build_query($query): '');
	}
}
?>