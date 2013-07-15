<?php
class Session{
	public static function login($user_email, $user_pass){
		$db=new DB();
		$query=	"SELECT user_id, user_email, user_pass, group_id FROM ".$db->prefix."users ".
				"WHERE user_email='$user_email' AND user_pass='$user_pass'";
		$args=	$db->get_row($query);
		if(count($args)){
			$args['token']=Session::getToken($args['user_id'], $args['user_pass']);
			Session::setSessionData($args);
			return TRUE;
		}
		return FALSE;				
	}
	public static function isValid(){
		return self::validateToken()&&is_numeric(self::getSessionData('user_id'));
	}
	public static function isAdmin(){
		$group_id=self::getSessionData('group_id');
		return $group_id==1;
	}
	private static function validateToken(){ //TODO: Validar token desde cookie
		$token=RequestHandler::getParameter('token', FALSE);
		if($token&&$session_token=self::getSessionData('token')){
			return $token==$session_token; //TODO: Sessiones válidas.
		}elseif($token){
			list($user_id, $user_pass)=explode('_', Tools::desencrypt($token));
			$db=new DB();
			$query=	"SELECT user_id, user_email, user_pass, group_id FROM ".$db->prefix."users ".
					"WHERE user_id=$user_id AND user_pass=$user_pass";
			$args=$db->get_row($query);
			if(count($args)){
				$args['token']=$token;
				$_SESSION['phm']=$args;
				return TRUE;
			}
		}
		return FALSE;
	}
	public static function getToken($user_id=NULL, $user_pass=NULL){
		return Tools::encrypt($user_id.'_'.$user_pass);
	}
	public static function setSessionData($args){
		if(is_array($args)){				
			foreach($args as $key => $val){
				$_SESSION['phm'][$key]=$val;
			}
		}
	}
	public static function getSessionData($key){
		return (isset($_SESSION['phm'])&&array_key_exists($key, $_SESSION['phm']))? $_SESSION['phm'][$key]: FALSE;
	}
	public static function closeSession(){
		$_SESSION['phm']=array();
	}
}
?>