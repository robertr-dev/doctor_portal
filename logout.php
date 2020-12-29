<?php
	include('./classes/database.php');
	include('./classes/Login.php');
	
	if(isset($_POST['confirm'])) {
			db2::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
			header('Location: index.php');
			die();
	}

	//if someone searches a username redirect them to that usernames profile
	if(isset($_POST['usernamesearch'])) {
		$requesteduser = $_POST['requestedusername'];
		header("Location: profile.php?username=".$requesteduser);
	}
	
	if(Login::isLoggedIn()) {
		$userid = Login::isLoggedIn();
		$username = db2::query('SELECT users.username FROM users WHERE id = :userid', array(':userid'=>$userid))[0]['username'];

	require('logged-in-header.php');
	?>
			<center>
			<h5>Logout</h5>
			Are you sure you want to log out?
			<form action="logout.php" method="post">
				<br />
				<input type="submit" name="confirm" value="Confirm" class="button-primary" id="custom-button-primary">
			</form>
			</center>
	<?php } else { require('not-logged-in-header.php'); ?>
			Please <a href="login.php">login</a> or <a href="create-account.php">register</a> to access this site.
		</center>
	<?php } require('footer.php'); ?>