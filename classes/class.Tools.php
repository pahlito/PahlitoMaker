<?php 
class Tools{
	public static function styleTags($css){
		$tags="";
		if(is_array($css)){
			foreach($css as $link){
				$tags .= '<link rel="stylesheet" href="'.$link['href'].'" media="'.$link['media'].'" />';
			}
		}
		return $tags;
	}
	public static function scriptTags($js){
		$tags="";
		if(is_array($js)){
			foreach($js as $script){
				$tags .= '<script type="'.$script['type'].'" src="'.$script['src'].'" ></script>';
			}
		}
		return $tags;
	}
	public static function encrypt($string){
		$secret=Config::getSecret();
		$hash="";
		if(strlen($secret)){
			$j=0;
			for($i=0; $i<strlen($string); $i++){
				$ord=(ord(substr($string, $i, 1))+ord(substr($secret, $j, 1)));
				$chr=chr($ord);
				$hash.=$chr;
				$j=($j+1<strlen($secret))?  $j+1: 0;
			}
		}
		return $hash? base64_encode($hash): $string;
	}
	public static function desencrypt($string){
		$secret=Config::getSecret();
		$string=base64_decode($string);
		$message="";
		if(strlen($secret)){
			$j=0;
			for($i=0; $i<strlen($string); $i++){
				$ord=ord(substr($string, $i, 1))-ord(substr($secret, $j, 1));
				$chr=chr($ord);
				$message.=$chr;
				$j=($j+1<strlen($secret))?  $j+1: 0;
			}
		}
		return $message? $message: $string;
	}
	public static function objectToArray($object){
		$array=(array)$object;
		foreach($array as $key=>$child){
			if(is_object($child)||is_array($child)) $array[$key]=self::objectToArray($child);
		}
		return $array;
	}
	public static function utf8_encode_array($array){		
		foreach($array as $key=>$child){
			if(is_object($child)||is_array($child)) $array[$key]=self::utf8_encode_array($child);
			elseif(is_string($child)) $array[$key]=utf8_encode($child);
		}
		return $array;
	}
	public static function debug($var){
		echo "<pre style=\"text-align:left\">";
		var_dump($var);
		echo "</pre>";
	}
}
?>
