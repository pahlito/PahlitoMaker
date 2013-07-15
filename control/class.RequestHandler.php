<?php
class RequestHandler {
	
	private $action_handler;
	private $action_name;
	private $status;
	
	private static $parameters;
	private static $post;
	private static $redirect;
	private static $css=array();
	private static $js=array();
	private static $formats=array();
	public function __construct(){
		self::$parameters=$_REQUEST;
		self::$post=$_POST;
		$this->action_name=self::getParameter('action', 'index');
		$this->action_handler=Action::getInstanceOf($this->action_name);
		if(is_null($this->action_handler)) self::error404();
		if(!empty($_POST)) $this->action_handler->postProcess();
		$this->action_handler->process();
	}
	public function getHTML(){
		$smarty= new Smarty();
		$smarty->setCompileDir('./cache/compile/')
       			->setCacheDir('./cache');	
		$smarty->assign(
			array(
				'title' => Config::getProjectTitle(),
				'css'=> Tools::styleTags(self::$css),
				'js'=> Tools::scriptTags(self::$js)
			)
		);
		$smarty->assign($this->action_handler->getDisplayObject());
		$action_template=Config::getThemeDir().$this->action_name.'.tpl';
		if(file_exists($action_template)){
			$smarty->display($action_template);
		}else{
			self::error404();			
		}
	}
	public function getJSON(){
		$JSONObject=$this->action_handler->getDisplayObject(); //TODO: Ver que pasa cuando hay un redirect, en particular en el caso de no haber token.
		if(!array_key_exists('status', $JSONObject)) $JSONObject['status']='200';
		if(!array_key_exists('action_name', $JSONObject)) $JSONObject['action_name']=$this->action_name;
		if(isset(self::$redirect)) $JSONObject['redirect']=self::$redirect;
		echo json_encode(Tools::utf8_encode_array($JSONObject)); //TODO: revisar
	}
	public function getResponse(){
		//TODO: ¿Otros archivos de control?
		$format=self::getFormat();
		switch($format['extention']){
			case 'json':
				$this->getJSON();
				break;
			default:
				$this->getHTML();
		}
	}
	
	/* STATIC */
	public static function redirect($URL){
		self::$redirect=$URL;
		$format=self::getFormat();
		if($format['can_redirect']){
			ob_clean();
			header('Location: '.$URL);
			exit();
		}
		return FALSE;
	}
	public static function getParameter($key, $default){
		return array_key_exists($key, self::$parameters)? self::$parameters[$key]: $default;
	}
	public static function getPost($key, $default){
		return array_key_exists($key, self::$post)? self::$post[$key]: $default;
	}
	public static function error404(){
		$error=Action::getActionURL('error404');
		RequestHandler::redirect($error);
	}
		
	/* STYLES */
	public static function addStyle($slug, $href, $media='screen'){
		self::$css[$slug]=array('href'=> $href, 'media'=> $media);
	}
	public static function removeStyle($slug){
		 if(array_key_exists($slug, self::$css)) unset(self::$css[$slug]);
	}
	
	/* SCRIPTS */
	public static function addScript($slug, $src, $type='text/javascript'){
		self::$css[$slug]=array('src'=> $src, 'type'=>$type);
	}
	public static function removeScript($slug){
		 if(array_key_exists($slug, self::$css)) unset(self::$css[$slug]);
	}
	public static function addFormat($extention, $canRedirect=FALSE){//TODO: Usar una expresion regular para validar extensión. 
		self::$formats[$extention]=array('extention'=> $extention,'can_redirect'=>$canRedirect);
	}
	public static function getFormat($default="html"){
		$extention=self::getParameter('format', $default);
		return array_key_exists($extention, self::$formats)? self::$formats[$extention]: $default;
	}
}
?>