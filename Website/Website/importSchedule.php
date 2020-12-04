<?php
include_once 'dbConfig.php';

$message = '';
//Process form
if(isset($_POST["importSubmit2"])){
  if($_FILES['file']['name']){
    // File uploaded
    // Process the input field form
    if(is_uploaded_file($_FILES['file']['tmp_name'])){
      // Opens the selected field & read its content
      $handle = fopen($_FILES['file']['tmp_name'], "r");
      // Fetch the content of csv file
      while($data = fgetcsv($handle)){
        $sched_id = mysqli_real_escape_string($conn, $data[0]);
        $sched_date = mysqli_real_escape_string($conn, $data[1]);
        $sched_time_start = mysqli_real_escape_string($conn, $data[2]);
        $sched_time_end = mysqli_real_escape_string($conn, $data[3]);
        $recollection_master = mysqli_real_escape_string($conn, $data[4]);
        $venue = mysqli_real_escape_string($conn, $data[5]);
        $term = mysqli_real_escape_string($conn, $data[6]);
        $academic_year = mysqli_real_escape_string($conn, $data[7]);
        $recollection_description = mysqli_real_escape_string($conn, $data[8]);
        $year_level = mysqli_real_escape_string($conn, $data[9]);
        $course_id = mysqli_real_escape_string($conn, $data[10]);

        $insertSchedule = " INSERT INTO schedule (sched_id, sched_date, sched_time_start, sched_time_end, recollection_master, venue, term, academic_year, recollection_description, year_level, course_id) VALUES
        ('$sched_id','$sched_date','$sched_time_start','$sched_time_end','$recollection_master','$venue','$term','$academic_year','$recollection_description','$year_level','$course_id')";

        $run_query = mysqli_query($conn, $insertSchedule);
      }
      fclose($handle);
    }
  }
}
// Redirect to the listing page
header("Location: Home.php". $message);
conn_close();
exit();

?>
