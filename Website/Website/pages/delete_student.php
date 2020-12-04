<?php
// Load the database configuration file
include_once '../dbConfig.php';
session_start();

if ($_POST['submit'] == 'remove'){
	//Delete Participants
	if(isset($_POST['checkbox'])){
		$selected = $_POST['checkbox'];
		foreach ($selected as $id_number) {
			//$delete_query = "DELETE From participants WHERE id_number =" . $id_number ;
			$delete_query = "DELETE From student_attendance WHERE id_number = " . $id_number. "&& sched_id =". $_SESSION['ID'];
			mysqli_query($conn, $delete_query);
		}
		$message = '?ID='.$_SESSION['ID'].'&&status=deleted';
	}
	// Redirect to the listing page
	header("Location: Schedule.php". $message);
	exit();

}
if ($_POST['submit'] == 'move'){
	//  Move Participants
	if(isset($_POST['checkbox'])){
	  $selected = $_POST['checkbox'];
		$sched_id = $_POST['schedule_id'];
	  foreach ($selected as $id_number) {
			$move_query = "UPDATE recollection.student_attendance SET sched_id = $sched_id WHERE id_number = $id_number";
	    //$move_query = "UPDATE student_info SET course_id = 102 WHERE id_number =" . $id_number. "&& sched_id =". $_SESSION['ID'];
			//UPDATE recollection.student_info SET course_id = 102 WHERE id_number = $id_number
			mysqli_query($conn, $move_query);
		}
		$message = '?ID='.$_SESSION['ID'].'&&status=added';
	}
	// Redirect to the listing page
	header("Location: Schedule.php". $message);
	exit();

}
if ($_POST['submit'] == 'attend'){
	//  Move Participants
	if(isset($_POST['checkbox'])){
	  $selected = $_POST['checkbox'];
		$sched_id = $_POST['schedule_id'];
		$Completed_status = "Completed";

	  foreach ($selected as $id_number) {
			$add_time = "UPDATE student_attendance
			INNER JOIN schedule
			ON student_attendance.sched_id = schedule.sched_id
			SET student_attendance.attendance_am = schedule.sched_time_start, student_attendance.attendance_pm = schedule.sched_time_end
			WHERE student_attendance.id_number = $id_number AND schedule.sched_id = $sched_id";

			$add_completed = "UPDATE student_history
			INNER JOIN student_info
			ON student_history.id_number = student_info.id_number
			SET student_history.1st_year = 'Completed'
			WHERE student_history.id_number = $id_number AND student_info.year = '1'";

			$add_completed2 = "UPDATE student_history
			INNER JOIN student_info
			ON student_history.id_number = student_info.id_number
			SET student_history.2nd_year = 'Completed'
			WHERE student_history.id_number = $id_number AND student_info.year = '2'";

			$add_completed3 = "UPDATE student_history
			INNER JOIN student_info
			ON student_history.id_number = student_info.id_number
			SET student_history.3rd_year = 'Completed'
			WHERE student_history.id_number = $id_number AND student_info.year = '3'";

			$add_completed4 = "UPDATE student_history
			INNER JOIN student_info
			ON student_history.id_number = student_info.id_number
			SET student_history.4th_year = 'Completed'
			WHERE student_history.id_number = $id_number AND student_info.year = '4'";

			mysqli_query($conn, $add_time);
			mysqli_query($conn, $add_completed);
			mysqli_query($conn, $add_completed2);
			mysqli_query($conn, $add_completed3);
			mysqli_query($conn, $add_completed4);
		}
		$message = '?ID='.$_SESSION['ID'].'&&status=marked';
	}
	// Redirect to the listing page
	header("Location: Schedule.php". $message);
	exit();

}

?>
