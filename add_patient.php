<?php
	require('classes/database.php');
  require('classes/Login.php');

  if(Login::isLoggedIn()) {

  require('logged-in-header.php');

  
  if(isset($_POST['add_patient'])) {

    $patient_name = $_POST['patient_name'];

    if(strlen($patient_name) >= 3 && strlen($patient_name) <= 32) {
        if(preg_match('/[a-zA-Z0-9_]+/', $patient_name)) {

          $query = 'INSERT INTO patients(name) VALUES (:patient_name)';
          $statement = $db->prepare($query);
          $statement->bindValue(':patient_name', $patient_name);
          $statement->execute();
          $statement->closeCursor();

          echo "
            <center>
            <h4 style='color:#35DA25;'>Patient created!</h4>
            </center>
            ";
        } else {
          echo "
            <center>
            <h4 style='color:#D52828;'>Invalid name</h4>
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
?>
    <div class="row">
      <div class="twelve columns">
        <center>
          <h5>New Patient</h5>

          <form action="add_patient.php" method="post">
            <div class="row">
              <div class="twelve columns">
                <label for="patientname">Patient name</label>
                <input type="text" placeholder="John Doe" name="patient_name" autocomplete="off">
              </div>
            </div><br />
            <input class="button-primary" type="submit" name="add_patient" value="Create Patient" id="custom-button-primary">
          </form>
        </center>
      </div>
    </div>

<?php require('footer.php'); } else { 
require('not-logged-in-header.php');
?>

    Please <a href="login.php">login</a> or <a href="create-account.php">register</a> to access this site.
  </center>

<?php require ('footer.php'); } ?>