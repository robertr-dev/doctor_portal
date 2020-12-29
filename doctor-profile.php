<?php
  require('classes/database.php');
  require('classes/Login.php');

  $doctorid = "";
  $user_id = Login::isLoggedIn();

  if(isset($_GET['doctor_id'])) {
    if(db2::query('SELECT id from users WHERE id=:doctorid', array(':doctorid'=>$_GET['doctor_id']))) {
      $doctorid = db2::query('SELECT id FROM users WHERE id=:doctorid', array(':doctorid'=>$_GET['doctor_id']))[0]['id'];
      $doctorname = db2::query('SELECT name FROM users WHERE id=:doctorid', array(':doctorid'=>$_GET['doctor_id']))[0]['name'];
    }
  } 
  
  if(Login::isLoggedIn()) {

  require('logged-in-header.php');
?>

    <div class="row">
      <div class="twelve columns">
        <center>
          <h5><?php 
            if(isset($_GET['doctor_id']) && $doctorid != "") { echo "Doctor Profile: $doctorname"; }
            else { echo "User not specified or does not exist."; }
          ?></h5>
        </center>
        <?php
        if(isset($_GET['doctor_id']) && $doctorid != "") { ?>
          <div class="twelve columns">
          <div id="caseColumn">
            <h6>Active Cases</h6>
            <?php 
                $query = "SELECT id, patient_id, patient_name, doctor_id, doctor_name, admission_date, admission_time, severity, admission_comments FROM cases WHERE doctor_id = '$doctorid' ORDER BY id DESC;";
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
        <?php } ?>
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