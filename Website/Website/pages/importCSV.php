<?php
// Load the database configuration file
include_once '../dbConfig.php';


if(isset($_POST['importSubmit'])){
        if($_FILES['file']['name']){

		    // File uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
			      fgetcsv($csvFile);
            // id_number,lname,fname,course,year,gender,attendance_am,attendance_pm
            // Parse CSV File data line by line
            while(($row = fgetcsv($csvFile)) !== FALSE){
    				$sched_id = $_SESSION['ID'];
    				$id_number = mysqli_real_escape_string($conn, $row[0]);
            $course = mysqli_real_escape_string($conn, $row[1]);
            $fname = mysqli_real_escape_string($conn, $row[2]);
    				$lname = mysqli_real_escape_string($conn, $row[3]);
    				$year_level = mysqli_real_escape_string($conn, $row[4]);
    				$gender = mysqli_real_escape_string($conn, $row[5]);
    				$attendance_AM = mysqli_real_escape_string($conn, $row[6]);
    				$attendance_PM =mysqli_real_escape_string($conn, $row[7]);

    				//Compare the ID number of the student and year level
            $existing_Participant = "SELECT * FROM student_attendance WHERE id_number = '".$row[0]."'";
            $result = $conn->query($existing_Participant);

            //Inserts the ID number to the Student Record table
            //Cannot import Null values on Attendance Am/Pm
            $conn->query("INSERT INTO student_attendance (id_number, sched_id, year, attendance_am, attendance_pm) VALUES ('".$id_number."','".$sched_id."','".$year_level."','".$attendance_AM."','".$attendance_PM."')");


        if($result->num_rows > 0){
        //Automatically update student status on the database and website.
        //BUG
          date_default_timezone_set("Asia/Manila");
					$absent_time_am = '8:15';
					//$absent_time_pm ="13:15";//WALA NA DAPAT TO
					
					//Set time limit for am and pm.
					$absent_time_am_sec = strtotime($absent_time_am);
					//$absent_time_pm_sec = strtotime($absent_time_pm);
					//Convert the time limit to seconds.
					$Time_Attended_AM = strtotime($attendance_AM);
					//$Absent_Time_Am_secAtAM = strtotime($attendance_AM); WHAT? attendance_am = absent_time????
					//$absent_time_pm_secAtPM = strtotime($attendance_PM);
					//Initialize a variable that holds to seconds.
					$status = '';

					//if ($absent_time_am_secAtAM >= $absent_time_am_sec || $absent_time_pm_secAtPM >=$absent_time_pm_sec) {


					if(($Time_Attended_AM >= $absent_time_am_sec) || empty($attendance_PM)) {
					//$statusAbs = "ABSENT"; 6 pack Abs???
					$Absent_status = "ABSENT";
						//For Absent 1st year students
						if($year_level == '1'){
							$conn->query("UPDATE student_history SET 1st_year = '".$Absent_status."' where student_history.id_number = '".$id_number."'");
							$conn->query("INSERT student_history SET 1st_year = '".$Absent_status."' where student_history.id_number = '".$id_number."'");
						}
						//For Absent 2nd year students
						if($year_level == '2'){
							$conn->query("UPDATE student_history SET 2nd_year = '".$Absent_status."' where student_history.id_number = '".$id_number."' ");
							$conn->query("INSERT student_history SET 2nd_year = '".$Absent_status."' where student_history.id_number = '".$id_number."'");
						}
						//For Absent 3rd year students
						if($year_level == '3'){
							$conn->query("UPDATE student_history SET 3rd_year = '".$Absent_status."' where student_history.id_number = '".$id_number."' ");
							$conn->query("INSERT student_history SET 3rd_year = '".$Absent_status."' where student_history.id_number = '".$id_number."'");
						}
						//For Absent 4th year students
						if($year_level == '4'){
							$conn->query("UPDATE student_history SET 4th_year = '".$Absent_status."' where student_history.id_number = '".$id_number."' ");
							$conn->query("INSERT student_history SET 4th_year = '".$Absent_status."' where student_history.id_number = '".$id_number."'");
						}

					}else{
						//$statusComp = "Completed"; statusComputer?
						$Completed_status = "Completed";

						//For 1st year students that completed the recollection
						if($year_level == '1'){
							$conn->query("UPDATE student_history SET 1st_year = '".$Completed_status."' where student_history.id_number = '".$id_number."' ");
							$conn->query("INSERT student_history SET 1st_year = '".$Absent_status."' where student_history.id_number = '".$id_number."'");
						}
						//For 2nd year students that completed the recollection
						if($year_level == '2'){
							$conn->query("UPDATE student_history SET 2nd_year = '".$Completed_status."' where student_history.id_number = '".$id_number."' ");
							$conn->query("INSERT student_history SET 2nd_year = '".$Completed_status."' where student_history.id_number = '".$id_number."' ");
						}
						//For 3rd year students that completed the recollection
						if($year_level == '3'){
							$conn->query("UPDATE student_history SET 3rd_year = '".$Completed_status."' where student_history.id_number = '".$id_number."' ");
							$conn->query("INSERT student_history SET 3rd_year = '".$Completed_status."' where student_history.id_number = '".$id_number."' ");
						}
						//For 4th year students that completed the recollection
						if($year_level == '4'){
							$conn->query("UPDATE student_history SET 4th_year = '".$Completed_status."' where student_history.id_number = '".$id_number."' ");
							$conn->query("INSERT student_history SET 4th_year = '".$Completed_status."' where student_history.id_number = '".$id_number."' ");
						}
					}
                    //Update attendance am/pm data in the database.
					$conn->query("UPDATE student_attendance SET attendance_AM = '".$attendance_AM."' WHERE student_attendance.id_number = '".$id_number."'");
					$conn->query("UPDATE student_attendance SET attendance_AM = NULL WHERE student_attendance.attendance_AM = '00:00'");
          $conn->query("UPDATE student_attendance SET attendance_PM = '".$attendance_PM."' WHERE student_attendance.id_number = '".$id_number."'");
          $conn->query("UPDATE student_attendance SET attendance_PM = NULL WHERE student_attendance.attendance_PM = '00:00'");
          }

			}
		}
            // Close opened CSV files
        fclose($csvFile);
			$message = '?ID='.$_SESSION['ID'].'&&status=success';
        }else{
            $message = '?ID='.$_SESSION['ID'].'&&status=error';
        }
    }else{
      $message = '?ID='.$_SESSION['ID'].'&&status=invalid_file';
    }



// Redirect to the listing page
header("Location: Schedule.php". $message);
conn_close();
exit();

?>
