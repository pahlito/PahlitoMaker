<?php
class LoginAction extends AbstractAction{
	private $email;
	private $error;
	public static $name='login';
	public static $parameters=array('return');
	public function process(){
		if(Session::isValid()){
			$redirectURL=RequestHandler::getParameter('return', Action::getActionURL('index'));
			RequestHandler::redirect($redirectURL);
		}
	}
	public function postProcess(){
		$this->email=trim(RequestHandler::getPost('email', FALSE));
		$pass=md5(RequestHandler::getPost('pass', ""));
		if($this->email&&filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			if(Session::login($this->email, $pass)){				
				$redirectURL=RequestHandler::getParameter('return', Action::getActionURL('index'));
				RequestHandler::redirect($redirectURL);
			}else{
				$this->error="Email o password incorrecto";
			}			
		}else{
			$this->error="Email no es válido";
		}
	}
	public function getDisplayObject(){
		return array(
			'email'=>$this->email,
			'error'=>$this->error,
			'post'=>$_POST,
			'token'=>Session::getSessionData('token')
		);
	}
}
?>