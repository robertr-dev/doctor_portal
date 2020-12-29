<?php
	include('classes/database.php');
	require('not-logged-in-header.php');
	if(isset($_POST['createaccount'])) {
		$username = $_POST['username'];
		$name = $_POST['name'];
		$password = $_POST['password'];
		
		//form validation
		//check if user already exists
		if(!db2::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
			
			//check if username is valid
			if(strlen($username) >= 3 && strlen($username) <= 32) {
				if(preg_match('/[a-zA-Z0-9_]+/', $username)) {

					//check if name is valid
					if(strlen($name) >= 3 && strlen($name) <= 32) {
						if(preg_match('/[a-zA-Z0-9_]+/', $name)) {
					
							//check if password is valid
							if(strlen($password) >= 6 && strlen($password) <= 60) {		

									//insert values into database
									db2::query('INSERT INTO users VALUES (\'\', :username, :name, :password)', array(':username'=>$username, ':name'=>$name, ':password'=>password_hash($password, PASSWORD_BCRYPT)));
									echo "
									    <center>
									    <h4 style='color:#35DA25;'>Account created!</h4>
									    </center>
									";

							}
							else {
								echo "
									    <center>
									    <h4 style='color:#D52828;'>Invalid password</h4>
									    </center>
									";
							}
						} else {
							echo "
									<center>
									    <h4 style='color:#D52828;'>Invalid name</h4>
									    </center>
									";
						}
					}
					else {
						echo "
								<center>
								    <h4 style='color:#D52828;'>Invalid name</h4>
								    </center>
								";
					}
				}
				else {
					echo "
							<center>
							    <h4 style='color:#D52828;'>Invalid username</h4>
							    </center>
							";
				}
			}
			else {
				echo "
						<center>
							<h4 style='color:#D52828;'>Invalid username</h4>
						</center>
					";
			}
		}
		else {
			echo "
					<center>
						<h4 style='color:#D52828;'>User already exists</h4>
					</center>
				";
		}
	}
?>
		<h5>Register</h5>
		<form action="create-account.php" method="post">
			<label for="username">Username</label>
			<input type="text" name="username" value="" placeholder="johndoe1997" autocomplete="off"><br />
			<label for="username">Name</label>
			<input type="text" name="name" value="" placeholder="John Doe" autocomplete="off"><br />
			<label for="username">Password</label>
			<input type="password" name="password" value="" placeholder="Password" autocomplete="off"><br /><br />
			<input type="submit" name="createaccount" value="Register" class="button-primary" id="custom-button-primary">
		</form>

		<p>
			<a href="index.php">Home</a> | 
			<a href="login.php">Login</a>
		</p>
		</center>

<?php
	require('footer.php');
?>