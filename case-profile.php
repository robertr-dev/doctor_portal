<?php
  require('classes/database.php');
  require('classes/Login.php');

  $caseid = "";
  $user_id = Login::isLoggedIn();

  if(isset($_GET['case_id'])) {
    if(db3::query('SELECT id from cases WHERE id=:caseid', array(':caseid'=>$_GET['case_id']))) {
      $caseid = db3::query('SELECT id FROM cases WHERE id=:caseid', array(':caseid'=>$_GET['case_id']))[0]['id'];

      $patientname = db3::query('SELECT patient_name FROM cases WHERE id=:caseid', array(':caseid'=>$_GET['case_id']))[0]['patient_name'];
      $patientid = db3::query('SELECT patient_id FROM cases WHERE id=:caseid', array(':caseid'=>$_GET['case_id']))[0]['patient_id'];

      $doctorname = db3::query('SELECT doctor_name FROM cases WHERE id=:caseid', array(':caseid'=>$_GET['case_id']))[0]['doctor_name'];
      $doctorid = db3::query('SELECT doctor_id FROM cases WHERE id=:caseid', array(':caseid'=>$_GET['case_id']))[0]['doctor_id'];

      $caseid = db3::query('SELECT id FROM cases WHERE id=:caseid', array(':caseid'=>$_GET['case_id']))[0]['id'];

    }
  } 
  
  if(Login::isLoggedIn()) {

  require('logged-in-header.php');
?>

    <div class="row">
      <div class="twelve columns">
        <center>
          <h5><?php 
            if(isset($_GET['case_id']) && $caseid != "") { echo "Case ID: $caseid"; }
            else { echo "Case not specified or does not exist."; }
          ?></h5>
        </center>
        </center>
          <div class="twelve columns">
          <div id="caseColumn">
            <?php 
                $query = "SELECT id, patient_id, patient_name, doctor_id, doctor_name, admission_date, admission_time, severity, admission_comments, doctor_comments FROM cases WHERE id = '$caseid' ORDER BY id DESC;";
                $statement = $db->prepare($query);
                $statement->execute();
                $caseslist = $statement->fetchAll();
                $statement->closeCursor();
              ?>
            <?php
              foreach($caseslist as $case) { ?>
                <ul>
                  <ul>
                    <li>
                      Patient: 
                      <a href="patient-profile.php?patient_id=<?php echo $case['patient_id'] ?>">
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
                    <li>Doctor Comments: <?php echo $case["doctor_comments"]; ?></li>
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
              <?php 
                } 
              ?>
          </div>
        </div>
      </div>
    </div>

<?php require('footer.php');
    
} else { require ('not-logged-in-header.php'); ?>
    Please <a href="login.php">login</a> or <a href="create-account.php">register</a> to access this site.
  </center>

<?php 
require('footer.php');
} 
?>