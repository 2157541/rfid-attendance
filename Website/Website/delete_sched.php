<?php
// Load the database configuration file
include_once 'dbConfig.php';
session_start();

	//Delete Participants
	if(isset($_POST['checkbox'])){
		
		//Collects the schedule ID
		$selected = $_POST['checkbox'];
		//Deletes all the selected checkbox
		foreach ($selected as $sched_id) {
			$query = "DELETE From schedule WHERE schedule.sched_id =" . $sched_id;
			mysqli_query($conn,$query);
		}
		$message = "?status=deleted"; 
	}else{
		$message = "?status=error"; 
	}
// Redirect to the listing page
header("Location: Home.php". $message);
exit();
?>
