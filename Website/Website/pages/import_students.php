<?php
include_once '../dbConfig.php';

$message = '';
//Process form
if(isset($_POST["csv_upload_btn"])){
  if($_FILES['file']['name']){
    // File uploaded
    // Process the input field form
    if(is_uploaded_file($_FILES['file']['tmp_name'])){
      // Opens the selected field & read its content
      $handle = fopen($_FILES['file']['tmp_name'], "r");
      // Fetch the content of csv file
      while($data = fgetcsv($handle)){
        $id_number = mysqli_real_escape_string($conn, $data[0]);
        $course = mysqli_real_escape_string($conn, $data[1]);
        $fname = mysqli_real_escape_string($conn, $data[2]);
        $lname = mysqli_real_escape_string($conn, $data[3]);
        $year = mysqli_real_escape_string($conn, $data[4]);
        $gender = mysqli_real_escape_string($conn, $data[5]);
        $status = mysqli_real_escape_string($conn, $data[6]);

        $insert = " INSERT INTO student_info (id_number, course, fname, lname, year, gender, status) VALUES ('$id_number', '$course', '$fname', '$lname', '$year', '$gender', '$status') ";
        $update = " UPDATE student_info SET course = '$course', year = '$year', status = '$status'
        WHERE id_number = '$id_number'";
        $insertid = "INSERT INTO student_history (id_number) VALUES ('$id_number')";

        $run_query = mysqli_query($conn, $insert);
        $run_query2 = mysqli_query($conn, $update);
        $run_query3 = mysqli_query($conn, $insertid);
      }

      fclose($handle);

    }
  }
}
// Redirect to the listing page
header("Location: StudRecord.php". $message);
conn_close();
exit();

?>
