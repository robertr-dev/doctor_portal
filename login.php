<?php
	include('classes/database.php');
	include('classes/Login.php');
	require('not-logged-in-header.php');
	
	if(isset($_POST['login'])) {
		$username = $_POST['doctor_username'];
		$password = $_POST['password'];
		
		//check if user exists
		if(db2::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
			
			//check if password entered equals account password
			if(password_verify($password, db2::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
				echo "Logged in! ";
				echo "Head to the <a href='index.php'>homepage</a>.";
				
				//generate token, 64 bytes to match token field in database table
				$cstrong = True;
				$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
				$user_id = db2::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
				
				//insert token into database, hashed for security
				db2::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
				
				//set cookies, valid for 1 week and 3 days
				setcookie("TPID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
				setcookie("TPID_", "1", time() + 60 * 60 * 24 * 3 , '/', NULL, NULL, TRUE);

				header("Location: index.php");
			}
			else {
				echo "
					<center>
						<h4 style='color:#D52828;'>Invalid password</h4>
					</center>
				";
			}
		}
		else {
			echo "
					<center>
						<h4 style='color:#D52828;'>User does not exist</h4>
					</center>
				";
		}
	}
?>
		<h5>Login</h5>
		<form action="login.php" method="post" autocomplete="off">
			<input type="text" name="doctor_username" placeholder="Username"><br />
			<input type="password" name="password" placeholder="Password"><br />
			<input type="submit" name="login" value="Login" class="button-primary" id="custom-button-primary">
		</form>

		<p>
			<a href="index.php">Home</a> | 
			<a href="create-account.php">Register</a>
		</p>
		</center>
<?php
require('footer.php');
?>