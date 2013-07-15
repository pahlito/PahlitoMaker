<?php
class Config {
	private static $file="project.cfg";
	private static $secret="phm_secret";
	private static $baseURL='./';
	protected static $config=array();
	
	public static $theme;
	
	/* URL */
	public static function setBaseURL($url){
		self::$baseURL=$url;
	}
	public static function getBaseURL(){
		return self::$baseURL;
	}
	
	/* TITLE */
	public static function getProjectTitle(){
		return self::$config['title'];
	}
	
	/* SECRET */
	public static function setSecret($secret){
		if(is_string($secret)&&strlen($secret)){
			self::$secret=$secret;
		}
	}
	public static function getSecret(){
		return self::$secret;
	}
	
	/* THEMES */
	public static function setTheme($theme){
		self::$theme= $theme.'/';
	}
	public static function getThemeURL(){
		return self::$baseURL.'/themes/'.self::$theme;
	}
	public static function getThemeDir(){
		return TEMPLATE_DIR.self::$theme;
	}
	
	/* TABLES */
	public static function getTablesConfig(){
		if(is_array(self::$config['tables'])){
			return self::$config['tables'];
		}
		return FALSE;
	}
	public static function getTableConfig($table_name){
		if(is_array(self::$config['tables'])){
			return array_key_exists($table_name, self::$config['tables'])? self::$config['tables'][$table_name]: FALSE;
		}
		return FALSE;
	}
	public static function userCan($action_name, $table_name){
		if(is_array(self::$config['tables'][$table_name]['actions'])){
			return in_array($action_name, self::$config['tables'][$table_name]['actions']);
		}
		return FALSE;
	}
	
	/* DATABASE */
	public static function getDatabaseConfig(){
		if(is_array(self::$config['database'])){
			return self::$config['database'];
		}
		return FALSE;
	}
	
	/* LOAD */
	public static function init(){
		if($config=Session::getSessionData('config')){
			self::$config=$config;
		}elseif($group_id=Session::getSessionData('group_id')){
			self::$config=self::loadUserConfig($group_id);
			Session::setSessionData(array('config'=>$config));
		}else{
			self::loadBaseConfig();
		}
	}
	public static function loadUserConfig($group_id){
		$config=self::loadBaseConfig();
		if($group_id){
			$db= new DB();
			$query= "SELECT table_name, action_name FROM ".$db->prefix."access ".
					"WHERE group_id=$group_id";
			$rows=$db->get_results($query);
			foreach($rows as $row){
				$config['tables'][$row['table_name']]['actions'][]=$row['action_name'];
			}
		}
		return $config;
	}
	protected static function loadBaseConfig(){
		if(file_exists(CONFIG_DIR.self::$file)){
			$enc_config=file_get_contents(CONFIG_DIR.self::$file);
			$plain_config=Tools::desencrypt($enc_config);
			$obj_config=json_decode($plain_config); 
			$config=Tools::objectToArray($obj_config);
			self::$config=$config;
			return $config;
		}
		return FALSE;
	}
	protected static function saveBaseConfig($config){
		self::$config=$config;
		$user_id=Session::getSessionData('user_id');
		$obj_config=json_encode($config);
		$db= new DB();
		$db->insert($db->prefix.'config_log', array('user_id'=>$user_id, 'config'=>$obj_config));
		file_put_contents(CONFIG_DIR.self::$file, Tools::encrypt($obj_config));		
	}
}
?>