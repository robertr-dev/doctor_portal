<?php
  require('classes/database.php');
  require('classes/Login.php');
  
  if(Login::isLoggedIn()) {

  require('logged-in-header.php');

  if(isset($_POST['add_case'])) {

    $patient_name = $_POST['patient_name'];

    $query = 'SELECT patients.id, patients.name FROM patients';
    $statement = $db->prepare($query);
    $statement->execute();
    $patientlist = $statement->fetchAll();
    $statement->closeCursor();

    foreach($patientlist as $patient):
      if($patient["name"] == $patient_name) {
        $patient_id = $patient['id'];
      }
    endforeach;

    $admission_date = $_POST['admission_date'];
    $admission_time = $_POST['admission_time'];
    $severity = $_POST['severity'];
    $admission_comments = $_POST['admission_comments'];

    $admission_date = (string)$admission_date;
    $admission_time = (string)$admission_time;

    if(strlen(trim($admission_comments)) <= 1000 && strlen(trim($admission_comments)) >= 5 && strlen($admission_date) > 0 && strlen($admission_time) > 0) {

      $query = 'INSERT INTO cases(patient_id, patient_name, admission_date, admission_time, severity, admission_comments) VALUES (:patient_id, :patient_name, :admission_date, :admission_time, :severity, :admission_comments)';
      $statement = $db->prepare($query);
      $statement->bindValue(':patient_id', $patient_id);
      $statement->bindValue(':patient_name', $patient_name);
      $statement->bindValue(':admission_date', $admission_date);
      $statement->bindValue(':admission_time', $admission_time);
      $statement->bindValue(':severity', $severity);
      $statement->bindValue(':admission_comments', $admission_comments);
      $statement->execute();
      $statement->closeCursor();

      echo "
        <center>
        <h4 style='color:#35DA25;'>Case Created!</h4>
        </center>
        ";
    } else {
      echo "
        <center>
        <h4 style='color:#D52828;'>One or more fields empty</h4>
        </center>
        ";
    }
  }
?>

    <div class="row">
      <div class="twelve columns">
        <center>
          <h5>New Case</h5>

          <form action="add_case.php" method="post">

            <?php 
              $query = 'SELECT patients.id, patients.name FROM patients';
              $statement = $db->prepare($query);
              $statement->execute();
              $patientlist = $statement->fetchAll();
              $statement->closeCursor();
              sort($patientlist);
            ?>

            <div class="row">
              <div class="twelve columns">
                <label for="patientname">Patient</label>
                <select id="patient_name" name="patient_name">
                  <?php foreach($patientlist as $patient): ?>
                      <option value="<?= $patient["name"]; ?>"><?= $patient['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="twelve columns">
                <label for="admissiondate">Admission date</label>
                <input type="date" name="admission_date">
              </div>
            </div>
            <div class="row">
              <div class="twelve columns">
                <label for="admissiontime">Admission time</label>
                <input type="time" name="admission_time">
              </div>
            </div>
            <div class="row">
              <div class="twelve columns">
                <label for="severity">Severity</label>
                <select name="severity">
                  <option value="Not Urgent">Not Urgent</option>
                  <option value="Important">Important</option>
                  <option value="Critical">Critical</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="twelve columns">
                <label for="admissioncomments">Admission comments</label>
                <textarea name="admission_comments" autocomplete="off">
                  
                </textarea>
              </div>
            </div><br />
            <input class="button-primary" type="submit" name="add_case" value="Create Case" id="custom-button-primary">
          </form>
        </center>
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