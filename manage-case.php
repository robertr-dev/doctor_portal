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

  if(isset($_POST['add_comment'])) {

      $comment = $_POST['comment'];

      $query = ("UPDATE cases SET doctor_comments = :comment WHERE cases.id = :caseid");
      $statement = $db->prepare($query);
      $statement->bindValue(':comment', $comment);
      $statement->bindValue(':caseid', $caseid);
      $statement->execute();
      $statement->closeCursor();

      echo "
        <center>
        <h4 style='color:#35DA25;'>Comment added!</h4>
        </center>
        ";
    }

    if(isset($_POST['delete_case'])) {

      $query = ("DELETE FROM cases WHERE cases.id = :caseid");
      $statement = $db->prepare($query);
      $statement->bindValue(':caseid', $caseid);
      $statement->execute();
      $statement->closeCursor();

      echo "
        <center>
        <h4 style='color:#D52828;'>Case deleted!</h4>
        </center>
        ";
    }
?>

    <div class="row">
      <div class="twelve columns">
        <center>
          <h5><?php 
            if(isset($_GET['case_id']) && $caseid != "") { echo "Manage Case ID: $caseid"; }
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
              foreach($caseslist as $case) { 
                if($user_id == $case["doctor_id"]) {
              ?>
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
                    <br />
                    Doctor Comments:
                      <form action="manage-case.php?case_id=<?php echo $case['id']; ?>" method="post">
                      <textarea name="comment" autocomplete="off"><?php echo $case["doctor_comments"]; ?></textarea>
                      <br />
                      <input class="button-primary" type="submit" name="add_comment" value="Add Comment" id="custom-button-primary">
                      </form>

                    <form action="manage-case.php?case_id=<?php echo $case['id']; ?>" method="post">
                      <input type="submit" name="delete_case" value="Delete Case" id="custom-button">
                      </form>
                  </ul>
              <?php 
                  } else {
                    echo "
                    <center>
                    You do not have permission to manage this case.
                    </center>
                    ";
                  }
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