<?php
	include_once '../dbConfig.php';
	//session_start();

	if(!isset($_SESSION['username'])){
    header('Location: Login.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: ../Login.php');
}

	//Collect the current page schedule ID
	$_SESSION['ID'] = $_GET['ID'];

	// Upload Status Message
	if(!empty($_GET['status'])){
		switch($_GET['status']){
			case 'success':
				$upload_status_msg = '<label class="text-success">Participants data has been imported successfully.</label>';
				break;
			case 'error':
				$upload_status_msg = '<script type="text/javascript">alert("Some problem occurred, please try again.");</script>';
				break;
			case 'invalid_file':
				$upload_status_msg = '<label class="text-danger">Please upload a valid CSV file.</label>';
				break;
			case 'added':
				$upload_status_msg = '<script type="text/javascript">alert("Participant(s) has been moved successfully.");</script>';
				break;
			case 'deleted':
				$upload_status_msg = '<script type="text/javascript">alert("Participant(s) has been deleted successfully.");</script>';
				break;
			case 'marked':
				$upload_status_msg = '<script type="text/javascript">alert("Participant(s) has been marked as present successfully.");</script>';
				break;
			default:
				$upload_status_msg = '';
		}
	}

	//Fetch the data needed for the schedule information and the total number of students and the attendies from mysql
	$schedule_info_query = "SELECT schedule.sched_id, schedule.sched_date,schedule.sched_time_start, schedule.sched_time_end, schedule.term,schedule.venue,
							schedule.recollection_master,schedule.recollection_description,
							course.course_name,
							schedule.year_level,
							COUNT(DISTINCT(student_attendance.id_number)) as TotalParticipants,
							COUNT(student_attendance.attendance_am) as attendiesAM,
							COUNT(student_attendance.attendance_pm) as attendiesPM
							FROM schedule
							INNER JOIN COURSE
							ON schedule.course_id = course.course_id
							INNER JOIN student_attendance
							ON schedule.sched_id = student_attendance.sched_id
							WHERE schedule.sched_id ='".$_SESSION['ID']."'";

	//Generates the data for the Schedule Information
	$result = mysqli_query($conn, $schedule_info_query);
		    while($row = mysqli_fetch_array($result) ){
				$sched_id = $row['sched_id'];
				$schedule_date = $row['sched_date'];
				$time_start = $row['sched_time_start'];
				$time_end = $row['sched_time_end'];
				$term = $row['term'];
				$venue = $row['venue'];
				$recollection_master = $row['recollection_master'];
				$recollection_description = $row['recollection_description'];
				$course_name = $row['course_name'];
				$year_level = $row['year_level'];
				$TotalParticipants = $row['TotalParticipants'];
				$Morning_Attendies = $row['attendiesAM'];
				$Afternoon_Attendies = $row['attendiesPM'];
			}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Schedule page</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/font.css"/>
		<link rel="stylesheet" type="text/css" href="../fontawesome/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<link rel="stylesheet" type="text/css" href="../css/datatable/datatables.min.css"/>
		<link rel="stylesheet" type="text/css" href ="../css/datatable/dataTables.bootstrap.min.css"/>
	</head>

	<body>
		<header>

			<!-- Navigation bar starts here -->
			<nav class="navbar navbar-expand-lg ">
				<div class="logo">
					<img src="../pictures/Logo.png" class="img-responsive" alt="Logo">
				</div>

				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">

					<ul class="navbar-nav ml-auto">
						<li class ="nav-item active">
							<i class="fas fa-home"></i>
							<a class="nav-link text-white" href="../Home.php">Home</a>
						</li>
						<li class ="nav-item">
							<i class="fas fa-clipboard"></i>
							<a class="nav-link text-white"  href="../pages/StudRecord.php">Student Record</a>
						</li>
						<li class ="nav-item">
							<i class="fas fa-chart-bar"></i>
							<a class="nav-link text-white" href="../pages/Statistic.php">Statistic</a>
						</li>
					</ul>

					<div class="navbar-nav dropdown">
						<button class="btn btn-light btn-circle btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-user"></i>
						</button>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						<form method='post' action="">
							<input class="dropdown-item" type="submit" value="Logout" name="but_logout"/>
						</form>
						</div>
					</div>

				</div>

				</div>
			</nav>
			<hr class="line">

			<div class = "header">
				<h1 class="text-center b-5">
				<!-- header --><?php echo $course_name,"(",$year_level,")", "<br><br>",
				" Schedule ID: ", $sched_id?>
				</h1>
			</div>


			<div class="card mx-auto mb-5">
				<div class="card-body">
					<div id="table" class="table-editable">

						<!-- Add/Update Schedule and Schedule Info button-->
						<div class = "margin-below">
							<div class = "text-right">
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#updateModal">Add/Update Participants</button>
								<button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#scheduleModal">Schedule Info</button>
							</div>
						</div>

						<!-- Schedule Information button Modal -->
						<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLongTitle">Schedule Information</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-lg-4">
												<label>Date:</label>
												<div class="input-group">
															<input type="text" class="form-control" value="<?php echo $schedule_date ?>" readonly=""/>
												</div>
											</div>

											<div class="col-lg-4">
											<label>Time start:</label>
													<div class="form-group">
														<div class="input-group date">
															<input type="text" class="form-control" value = "<?php echo $time_start ?>" readonly=""/>
														</div>
													</div>
											</div>

											<div class="col-lg-4">
											<label>Term:</label>
												<div class="input-group">
													<input class="form-control datetimepicker-input" value = "<?php echo $term ?>" readonly=""/>
												</div>
											</div>
										</div> <!-- Row ends here-->

										<div class = "row">
											<div class ="col-lg-12">
												<label>Venue:</label>
													<div class="input-group">
														<input type="text" class="form-control" value = "<?php echo $venue ?>" readonly=""/>
													</div>
											</div>
										</div>

										<div class = "row">
											<div class ="col-lg-12">
												<label>Recollection Master:</label>
												<input type="text" class="form-control" value = "<?php echo $recollection_master ?>" readonly=""/>
											</div>
										</div>

										<div class = "row">
											<div class ="col-lg-12">
												<label>Recollection Description:</label>
												<input type="text" class="form-control" value = "<?php echo $recollection_description ?>" readonly=""/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End of Add modal-->

					<!-- Add/Update Participants Modal -->
					<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Add/Update Participants</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>

							<!-- Modalbody starts here-->
							<form action="importCSV.php" method="POST" enctype="multipart/form-data">
								<div class="modal-body">

									<!-- Drop Zone -->
									<div class="upload-drag-drop2" id = "file_upload">
										<div class="file_input_div" style="display: inline;">
											<input type="button" style="position: absolute; left: -40px; opacity: 0; z-index; -1;"  id="button" value="Open"/>
											<div id="name" style="pointer-events: none;">Drag your files here</div>
											<div id="name2" style="pointer-events: none;">or select a .csv file from your computer</div>
											<input type="file" name="file" id="js-upload-files"
											style="position: relative;
											border: dashed;
											border-color: #385178;
											background-color: #f2f2f2;
											padding-top: 20%;
											padding-right: 25%;
											padding-bottom: 50px;
											padding-left: 35%;"
											onchange="javascript: document.getElementById ('file_upload') . value = this.value" multiple/>
										</div>
									</div>


								<!-- Display status message -->
								<h6><?php if(!empty($upload_status_msg)){
									echo  $upload_status_msg;
								}?></h6>

								</div>
								<!-- Modal footer starts here-->
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary" name="importSubmit">Submit</button>
									<button  type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
								</div>
								<!-- Modal footer ends here-->
							</form>

							</div>
						</div>
					</div>

					<br>


				<!-- Move and Remove Participant -->
				<form action="delete_student.php" method="post" onSubmit="return delete_confirm();">
					<table id="data_table" class="table table-bordered table-responsive-sm table-striped text-center table-bordered">
						<thead>
							<tr class="cardcolor" >
								<th> </th>
								<th>I.D number</th>
								<th>Last Name</th>
								<th>First Name</th>
								<th>Course</th>
								<th>Year</th>
								<th>Gender</th>
								<th>A.M</th>
								<th>P.M</th>
							</tr>
						</thead>

						<?php
							$table_query = "SELECT student_info.id_number, student_info.lname, student_info.fname, student_info.course,
											student_info.year, student_info.gender, student_attendance.attendance_am, student_attendance.attendance_pm
											FROM student_info
											INNER JOIN student_attendance
											ON student_info.`id_number` = student_attendance.`id_number`
											WHERE sched_id ='".$_SESSION['ID']."'
											GROUP BY lname ASC";


							$result = mysqli_query($conn,$table_query);
							while($row = mysqli_fetch_array($result) ){ ?>
							<tr>
								<td><input type="checkbox" name="checkbox[]" class="checkbox" value = "<?php echo $row['id_number']?>"/></td>
								<td><?php echo $row['id_number'];?></td>
								<td><?php echo $row['lname'];?></td>
								<td><?php echo $row['fname'];?></td>
								<td><?php echo $row['course'];?></td>
								<td><?php echo $row['year'];?></td>
								<td><?php echo $row['gender'];?></td>
								<td><?php if(!empty($row['attendance_am'])){
										  echo date('H:i', strtotime($row['attendance_am']));
										}?></td>
								<td><?php if(!empty($row['attendance_am'] && $row['attendance_pm'])){
									      echo date('H:i', strtotime($row['attendance_pm']));
										} if(!empty($row['attendance_pm'] && empty($row['attendance_am']))){
											  echo date('H:i', strtotime($row['attendance_pm']));
										}?></td></tr>
							<?php } ?>
					</div>

					<div class = "text-center" style="margin-bottom: 1%;">
						<label class="mdb-main-label">Select Date</label>
						<select class="mdb-select md-form colorful-select dropdown-primary" name="schedule_id">
							<?php
							$res=mysqli_query($conn, "SELECT sched_id, sched_date FROM recollection.schedule");
							while($row=mysqli_fetch_array($res)){
							echo '<option value="'.$row['sched_id'].'">('.$row['sched_id'].') '.$row['sched_date'].'</option>';
							 	}
							  ?>
						</select>

						<button type="submit" class="btn btn-primary" name="submit" value="move">Move Participant</button>
						<button type="submit" class="btn btn-primary" name="submit" value="attend">Mark as Attended</button>
						<button type="submit" class="btn btn-outline-danger" class="btn btn-danger" id= "submit" name="submit" value="remove">Remove Participant</button>

					</div>

					</table>
				</form>

					<div class="input-group mt-5">

					<h6 class = "margin-top">Number of Participants: </h6>
						<div class="col-sm-1">
							<input type="text" class="form-control" value="<?php echo $TotalParticipants;?>" readonly=""/>
						</div>

					<h6 class = "margin-top2"> Total Attendies: </h6>
						<div class="col-sm-1">
							<input type="text" class="form-control" value="<?php echo $Morning_Attendies;?>" readonly=""/>
						</div>
						<div class="col-sm-1">
							<input type="text" class="form-control" value="<?php echo $Afternoon_Attendies; ?>" readonly=""/>
						</div>
					</div>

				</div>
			</div>
		</header>

		<footer class="card-footer bg-primary">
			  <div class="footer-copyright text-center py-3">© Saint Louis University Recollection Website
			  </div>
		</footer>

		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/popper.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/datatables.min.js"></script>
		<script type="text/javascript" src="../js/script.js"></script>
		<script>

		//DataTable Javascript Library
		$(document).ready(function () {;
			$('#data_table').DataTable();
		});
		</script>

	</body>
</html>
