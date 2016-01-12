<?php
Auth::DoHandshake();
class Auth{
	public static $user;
	public static $domain;
	public static $workstation;
	public static function DoHandshake(){
                session_start();
                $_SESSION['user'] = 'test'.rand(0,100000);
                self::$user = $_SESSION['user'];
                self::$domain = 'microsoft';
                self::$workstation = 'microsoft';
                return;
		if(!function_exists("apache_request_headers")){
			$str = $_SERVER["REMOTE_USER"];
			$str = explode("\\", $str);
			self::$user = $str[1];
			self::$domain = $str[0];
			return;
		}
		
		$headers = apache_request_headers();
		
		if (!isset($headers['Authorization'])){
			header('HTTP/1.1 401 Unauthorized');
			header('WWW-Authenticate: NTLM');
			exit;
		}

		$auth = $headers['Authorization'];
		if (substr($auth,0,5) == 'NTLM ') {
			$msg = base64_decode(substr($auth, 5));
			if (substr($msg, 0, 8) != "NTLMSSP\x00")
				die('error header not recognised');
			if ($msg[8] == "\x01") {
				$msg2 = "NTLMSSP\x00\x02\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x01\x02\x81\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00";
				header('HTTP/1.1 401 Unauthorized');
				header('WWW-Authenticate: NTLM '.trim(base64_encode($msg2)));
				exit;
			}
			else if ($msg[8] == "\x03") {
				function get_msg_str($msg, $start, $unicode = true) {
					$len = (ord($msg[$start+1]) * 256) + ord($msg[$start]);
					$off = (ord($msg[$start+5]) * 256) + ord($msg[$start+4]);
					if ($unicode)
						return str_replace("\0", '', substr($msg, $off, $len));
					else
						return substr($msg, $off, $len);
				}
				self::$user = get_msg_str($msg, 36);
				self::$domain = get_msg_str($msg, 28);
				self::$workstation = get_msg_str($msg, 44);

			}
		}	
	}	
}
?>
