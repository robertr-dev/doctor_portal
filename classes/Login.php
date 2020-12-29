<?php
	class Login {
		public static function isLoggedIn() {
			if(isset($_COOKIE['TPID'])) {
				
				//check if cookie token is equal to any users token
				if(db2::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['TPID'])))) {
					$userid = db2::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['TPID'])))[0]['user_id'];
					
					if(isset($_COOKIE['TPID_'])) {
						return $userid;
					}
					else {
						
						//generate 64 bit token to match token field in database
						$cstrong = True;
						$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
						
						//insert new token into database
						db2::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
						//delete old token
						db2::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['TPID'])));
						
						//set 2 cookies, valid for 1 week and 3 days
						setcookie("TPID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
						setcookie("TPID_", "1", time() + 60 * 60 * 24 * 3 , '/', NULL, NULL, TRUE);
						
						return $userid;
					}
				}
			}
			
			return false;
		}
	}
?>