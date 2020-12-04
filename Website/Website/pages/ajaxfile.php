<?php
include "../dbConfig.php";

$id_number = $_POST['id_number'];

$Student_Info_query = "SELECT student_info.id_number, student_info.lname, student_info.fname, student_info.course, student_info.status,
		MAX(student_info.year) as year,student_info.gender
		FROM student_info
		INNER JOIN student_attendance
		ON student_info.id_number = student_attendance.id_number
		WHERE student_info.`id_number` =". $id_number;
		
$result = mysqli_query($conn,$Student_Info_query);
$output = "<table border='0' width='100%'>";
while( $row = mysqli_fetch_array($result)){
	//Row 1
	$output .="<div class='row'>";
	$output .="<div class='col-lg-4'>";
	$output .="<label>ID number</label>";
	$output .="<div class='input-group'>";
	$output .="<input type='text' class='form-control' value='".$row['id_number']."' readonly=''/>";
	$output .="</div>";
	$output .="</div>";
	
	$output .="<div class='col-lg-4'>";
	$output .="<label>Year level</label>";
	$output .="<div class='input-group'>";
	$output .="<input type='text' class='form-control' value='".$row['year']."' readonly=''/>";
	$output .="</div>";
	$output .="</div>";
	
	$output .="<div class='col-lg-4'>";
	$output .="<label>Status</label>";
	$output .="<div class='input-group'>";
	$output .="<input type='text' class='form-control' value='".$row['status']."' readonly=''/>";
	$output .="</div>";
	$output .="</div>";
	$output .="</div>";
	
	
	//Row 2
	$output .="<div class='row'>";
	$output .="<div class='col-lg-4'>";
	$output .="<label>Last Name</label>";
	$output .="<div class='input-group'>";
	$output .="<input type='text' class='form-control' value='".$row['lname']."' readonly=''/>";
	$output .="</div>";
	$output .="</div>";
	
	$output .="<div class='col-lg-4'>";
	$output .="<label>First Name</label>";
	$output .="<div class='input-group'>";
	$output .="<input type='text' class='form-control' value='".$row['fname']."' readonly=''/>";
	$output .="</div>";
	$output .="</div>";
	
	$output .="<div class='col-lg-4'>";
	$output .="<label>Course</label>";
	$output .="<div class='input-group'>";
	$output .="<input type='text' class='form-control' value='".$row['course']."' readonly=''/>";
	$output .="</div>";
	$output .="</div>";
	$output .="</div>";
}

/*Student Attendances Row*/
//1st Year Data Row
$First_Year_sql = "SELECT student_history.id_number,schedule.sched_date,student_attendance.year,student_attendance.`attendance_am`,student_attendance.`attendance_pm`, student_history.1st_year FROM `student_attendance` INNER JOIN student_history ON student_attendance.id_number = student_history.id_number INNER JOIN schedule ON student_attendance.sched_id = schedule.sched_id WHERE `year` = 1 && student_history.id_number=". $id_number;
$result = mysqli_query($conn,$First_Year_sql);
while( $row = mysqli_fetch_array($result)){
	$output .="<table style='width:100%' class='table table-bordered table-responsive-sm table-striped text-center table-bordered'>";
	$output .="<thead>";
	$output .="<tr>";
	$output .="<br>";
	$output .="<th>Year level</th>";
	$output .="<th>Date Attended</th>";
	$output .="<th>A.M</th>";
	$output .="<th>P.M</th>";
	$output .="<th>Attendance Status</th>";
	$output .="</tr>";
	$output .="</thead>";
	
	$output .="<tbody>";
	$output .="<tr>";
	
	$output .="<td>".$row['year']."</td>";
	$output .="<td>".$row['sched_date']."</td>";
	$output .="<td>".$row['attendance_am']."</td>";
	$output .="<td>".$row['attendance_pm']."</td>";
	$output .="<td>".$row['1st_year']."</td>";
}
//2nd Year Data Row
$Second_Year_sql = "SELECT student_history.id_number,schedule.sched_date,student_attendance.year,student_attendance.`attendance_am`,student_attendance.`attendance_pm`,student_history.2nd_year FROM `student_attendance` INNER JOIN student_history ON student_attendance.id_number = student_history.id_number INNER JOIN schedule ON student_attendance.sched_id = schedule.sched_id WHERE `year` = 2 && student_history.id_number=". $id_number;
$result = mysqli_query($conn,$Second_Year_sql);
while( $row = mysqli_fetch_array($result)){
	$output .="<tbody>";
	$output .="<tr>";
	
	$output .="<td>".$row['year']."</td>";
	$output .="<td>".$row['sched_date']."</td>";
	$output .="<td>".$row['attendance_am']."</td>";
	$output .="<td>".$row['attendance_pm']."</td>";
	$output .="<td>".$row['2nd_year']."</td>";
	
	$output .="</tr>";
	$output .="</tbody>";
	
}
//3rd Year Data Row
$Third_Year_sql = "SELECT student_history.id_number,schedule.sched_date,student_attendance.year,student_attendance.`attendance_am`,student_attendance.`attendance_pm`,student_history.3rd_year FROM `student_attendance` INNER JOIN student_history ON student_attendance.id_number = student_history.id_number INNER JOIN schedule ON student_attendance.sched_id = schedule.sched_id WHERE `year` = 3 && student_history.id_number=". $id_number;
$result = mysqli_query($conn,$Third_Year_sql );
while( $row = mysqli_fetch_array($result)){
	$output .="<tbody>";
	$output .="<tr>";
	
	$output .="<td>".$row['year']."</td>";
	$output .="<td>".$row['sched_date']."</td>";
	$output .="<td>".$row['attendance_am']."</td>";
	$output .="<td>".$row['attendance_pm']."</td>";
	$output .="<td>".$row['3rd_year']."</td>";
	
	$output .="</tr>";
	$output .="</tbody>";

}
//4th Year Data Row
$Forth_Year_sql = "SELECT student_history.id_number,schedule.sched_date,student_attendance.year,student_attendance.`attendance_am`,student_attendance.`attendance_pm`,student_history.4th_year FROM `student_attendance` INNER JOIN student_history ON student_attendance.id_number = student_history.id_number INNER JOIN schedule ON student_attendance.sched_id = schedule.sched_id WHERE `year` = 4 && student_history.id_number=". $id_number;
$result = mysqli_query($conn,$Forth_Year_sql);
while($row = mysqli_fetch_array($result)){
	$output .="<tbody>";
	$output .="<tr>";
	
	$output .="<td>".$row['year']."</td>";
	$output .="<td>".$row['sched_date']."</td>";
	$output .="<td>".$row['attendance_am']."</td>";
	$output .="<td>".$row['attendance_pm']."</td>";
	$output .="<td>".$row['4th_year']."</td>";
	
	$output .="</tr>";
	$output .="</tbody>";
}
$output .= "</table>";

echo $output;
exit;