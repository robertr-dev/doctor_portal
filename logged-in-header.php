<?php
	if(Login::isLoggedIn()) { 

	$userid = Login::isLoggedIn();

	$doctor_name = db2::query('SELECT users.name FROM users WHERE id = :userid', array(':userid'=>$userid))[0]['name'];

	$doctor_username = db2::query('SELECT users.username FROM users WHERE id = :userid', array(':userid'=>$userid))[0]['username'];
	
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Doctor Patient Portal</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/skeleton.css">
		<link rel="stylesheet" href="css/pure-min.css">
	</head>
	<body>
		<div class="header">

		<center>
			
			<h3 style="margin-bottom: 0px;">Doctor Patient Portal</h3>
			<?php echo "<p style='margin-top: 0px; margin-bottom: 0px; font-size: 0.8em;'>You are signed in as $doctor_name ($doctor_username)</p>"; ?>
			<br />
		</center>
		</div>
		<center>
		<div class="custom-menu">
			<div class="pure-menu pure-menu-horizontal">
    			<ul class="pure-menu-list">
        			<li class="pure-menu-item">
            			<a href="index.php" class="pure-menu-link" id="custom-link">Home</a>
        			</li>
       				<li class="pure-menu-item">
            			<a href="doctor-profile.php?doctor_id=<?php echo $userid; ?>" class="pure-menu-link" id="custom-link">My Cases</a>
        			</li>
        			<li class="pure-menu-item">
            			<a href="add_case.php" class="pure-menu-link" id="custom-link">New Case</a>
        			</li>
        			<li class="pure-menu-item">
            			<a href="add_patient.php" class="pure-menu-link" id="custom-link">New Patient</a>
        			</li>
        			<li class="pure-menu-item">
            			<a href="logout.php" class="pure-menu-link" id="custom-link">Logout</a>
        			</li>
    			</ul>
			</div>
		</div>	
		</center>
		<br />