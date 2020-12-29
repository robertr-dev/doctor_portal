<?php
	require('classes/database.php');
	require('classes/Login.php');

?>
<?php
	if(Login::isLoggedIn()) { 

	require('logged-in-header.php');

	$user_id = Login::isLoggedIn();

	if(isset($_POST['accept_case'])) {
	    
	    $case_id = $_POST['case_id'];
	    
	    $data = [
	    	'user_id' => $user_id,
	    	'case_id' => $case_id,
	    ];
	    
	    $query = '
	    UPDATE cases SET doctor_id = :user_id WHERE cases.id = :case_id;
	    ';

	    $statement = $db->prepare($query);
	    $statement->execute($data);
	    $statement->closeCursor();

	    $data = [
	    	'doctor_name' => $doctor_name,
	    	'case_id' => $case_id,
	    ];

	    $query = '
	    UPDATE cases SET doctor_name = :doctor_name WHERE cases.id = :case_id;
	    ';

	    $statement = $db->prepare($query);
	    $statement->execute($data);
	    $statement->closeCursor();

	    echo "
	    <center>
	    <h4 style='color:#35DA25;'>Case ID $case_id accepted as $doctor_name!</h4>
	    </center>
	    ";
	    
	    header('Location: manage-case.php?case_id=' . $case_id);
	}

	if(isset($_POST['case_search'])) {
		$requested_case = $_POST['requested_case'];
		if(strlen($requested_case) >= 1 && strlen($requested_case) <= 9999 && is_numeric($requested_case)) {
				header("Location: case-profile.php?case_id=".$requested_case);
		} else {
			echo "
	            <center>
	            <h4 style='color:#D52828;'>Invalid Case ID</h4>
	            </center>
          	";
		}
	}
?>
			<div class="row">
		    	<div class="twelve columns">
		    		<center>
		    			<form action="index.php" method="post" style="margin-bottom: 0px;">
			    			<input type="text" name="requested_case" placeholder="Case Search by ID" autocomplete="off"><br /><br />
							<input class="button-primary" type="submit" value="Search" name="case_search" id="custom-button-primary">
						</form>
					</center>
		    	</div>
		  	</div>
	  	<hr />
	  	<div class="row">
	  		<div class="six columns">
	  			<div id="caseColumn">
	  				<h5>Available Cases</h5>
	  				<?php 
			        	$query = "SELECT id, patient_id, patient_name, doctor_id, doctor_name, admission_date, admission_time, severity, admission_comments FROM cases WHERE doctor_name LIKE '' ORDER BY id DESC;";
			        	$statement = $db->prepare($query);
			        	$statement->execute();
			        	$caseslist = $statement->fetchAll();
			        	$statement->closeCursor();
			        ?>
	  				<hr />
	  				<?php
	  					foreach($caseslist as $case) { ?>
	  						<ul>
	  							<li><b>Case ID: 
	  								<a href="case-profile.php?case_id=<?php echo $case['id']; ?>">
	  								<?php echo $case['id']; ?>
	  								</a>
	  								</b></li>
	  							<ul>
	  								<li>
	  									Patient: 
	  									<a href="patient-profile.php?patient_id=<?php echo $case['patient_id'] ?>">
	  									<?php echo $case["patient_name"]; ?>
	  									</a>
	  								</li>
	  								<li>Admitted: <?php echo $case["admission_date"]; ?> at <?php echo $case["admission_time"]; ?></li>
	  								<li>Severity: <?php echo $case["severity"]; ?></li>
	  								<li>Admission Comments: <?php echo $case["admission_comments"]; ?></li>
	  								<form action="index.php" method="post">
	  									<input type="hidden" name="case_id" value="<?php echo $case['id']; ?>">
	  									<input type="submit" name="accept_case" value="Accept Case" id="custom-button">
	  								</form>
	  							</ul>
	  						</ul>
	  					<?php 
	  						} 
	  					?>
	  			</div>
	  		</div>
	  		<div class="six columns">
	  			<div id="caseColumn">
	  				<h5>Active Cases</h5>
	  				<?php 
			        	$query = "SELECT id, patient_id, patient_name, doctor_id, doctor_name, admission_date, admission_time, severity, admission_comments FROM cases WHERE doctor_name NOT LIKE '' ORDER BY id DESC";
			        	$statement = $db->prepare($query);
			        	$statement->execute();
			        	$caseslist = $statement->fetchAll();
			        	$statement->closeCursor();
			        ?>
	  				<hr />
	  				<?php
	  					foreach($caseslist as $case) { ?>
	  						<ul>
	  							<li><b>Case ID: 
	  								<a href="case-profile.php?case_id=<?php echo $case['id']; ?>">
	  								<?php echo $case["id"]; ?>
	  								</a>
	  								</b></li>
	  							<ul>
	  								<li>
	  									Patient: 
	  									<a href="patient-profile.php?patient_id=<?php echo $case['patient_id']; ?>">
	  									<?php echo $case["patient_name"]; ?>
	  									</a>
	  								</li>
	  								<li>
	  									Doctor: 
	  									<a href="doctor-profile.php?doctor_id=<?php echo $case['doctor_id']; ?>">
	  									<?php echo $case["doctor_name"]; ?>
	  									</a>
	  								</li>
	  								<li>Admitted: <?php echo $case["admission_date"]; ?> at <?php echo $case["admission_time"]; ?></li>
	  								<li>Severity: <?php echo $case["severity"]; ?></li>
	  								<li>Admission Comments: <?php echo $case["admission_comments"]; ?></li>
	  								<?php

									    if($user_id == $case["doctor_id"]) {
									    	?>
									    	<form action="manage-case.php?case_id=<?php echo $case['id']; ?>" method="post">
			  									<input type="hidden" name="case_id" value="<?php echo $case['id']; ?>">
			  									<input type="submit" name="manage_case" value="Manage Case" id="custom-button">
			  								</form>
									    	<?php
									    }
	  								?>
	  							</ul>
	  						</ul>
	  					<?php 
	  						} 
	  					?>
	  			</div>
	  		</div>
	  	</div>

	  	<?php require('footer.php'); ?>
<?php 
} else { 
	require('not-logged-in-header.php');
	?>
		Please <a href="login.php">login</a> or <a href="create-account.php">register</a> to access this site.
	</center>
<?php
	require('footer.php');
	
	}
?>