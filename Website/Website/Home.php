<?php
include_once "dbConfig.php";
//session_start();

// Check user login or not
if(!isset($_SESSION['username'])){
    header('Location: Login.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: Login.php');
}

	//Delete Schedule Status
	if(!empty($_GET['status'])){
		switch($_GET['status']){
			case 'deleted':
				$upload_status_msg = '<script type="text/javascript">alert("Schedule(s) has been deleted successfully.");</script>';
				break;
			case 'error':
				$upload_status_msg = '<script type="text/javascript">alert("Some problem occurred, please try again.");</script>';
				break;
			default:
				$upload_status_msg = '';
		}
	}
	//Status Message
	if(!empty($upload_status_msg)){
		echo  $upload_status_msg;
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
		<title>Home page</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" type="text/css" href="css/datatable/datatables.min.css"/>
		<link rel="stylesheet" type="text/css" href ="css/datatable/dataTables.bootstrap.min.css"/>
	</head>

	<body>
		<header>
			<!-- Navigation bar starts here -->
			<nav class="navbar navbar-expand-lg ">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="logo">
						<img src="pictures/Logo.png" class="img-responsive" alt="Logo">
				</div>

				<div class="collapse navbar-collapse" id="navbarTogglerDemo01">

					<ul class="navbar-nav ml-auto">
						<li class ="nav-item active">
							<i class="fas fa-home"></i>
							<a class="nav-link text-white" href="Home.php">Home</a>
						</li>
						<li class ="nav-item">
							<i class="fas fa-clipboard"></i>
							<a class="nav-link text-white"  href="pages/StudRecord.php">Student Record</a>
						</li>
						<li class ="nav-item">
							<i class="fas fa-chart-bar"></i>
							<a class="nav-link text-white" href="pages/Statistic.php">Statistic</a>
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
			<!-- Navigation bar starts here -->

			<!-- Title -->
			<div class = "header">
				<?php
					$dropDown_query = "SELECT MAX(academic_year) as academic_year FROM schedule";
					$result = mysqli_query($conn, $dropDown_query);
					while($row = mysqli_fetch_array($result)){
						echo '<h1 class="text-center b-5">Recollection A.Y '.$row['academic_year'].'</h1>';
					}
				?>
			</div>

			<!-- Select DropDown starts here -->
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
						<div class= "input-group">
							<h5>School:  </h5>
						    <select class="custom-select" id="school">
								<option disabled="" selected=""> Select</option>
								<?php
									$dropDown_query = "SELECT * FROM school ORDER BY school_name ASC";
									$result = mysqli_query($conn, $dropDown_query);
										while($row = mysqli_fetch_array($result)){
											  echo '<option value="'.$row['school_id'].'">'.$row['school_name'].'</option>';
										}
								?>
							  </select>
						</div>
					</div>

					<div class="col-lg-3">
							<div class="input-group" >
							<h5> Course:  </h5>
							  <select class="custom-select"id ="course">
								<option disabled="" selected="">Select School first</option>
							  </select>
							</div>
					</div>

						<div class="col-lg-4">
							<div class="input-group">
							<h5> Academic Year:  </h5>
							  <select class="custom-select" id = "acadamic_year">
									<option  disabled="" selected=""> Select</option>
									<?php
									$dropDown_query = "SELECT DISTINCT academic_year FROM schedule";
									$result = mysqli_query($conn, $dropDown_query);
										while($row = mysqli_fetch_array($result)){
											echo '<option value = "academic_year">'.$row['academic_year'].'</option>';
										}
									?>
							  </select>
							</div>
						</div>

					<div class="col-lg-2">
							<div class="input-group">
							<h5> Term:  </h5>
							  <select class="custom-select" id = "term">
								<option  disabled="" selected=""> Select</option>
									<?php
									$dropDown_query = "SELECT DISTINCT term FROM schedule";
									$result = mysqli_query($conn, $dropDown_query);
										while($row = mysqli_fetch_array($result)){
											echo '<option value = "term">'.$row['term'].'</option>';
										}
									?>
							  </select>
							</div>
					</div>
				</div>
			</div>
			<!-- Choose end here -->

			<br>

			<div class="card mx-auto mb-5">
			  <h4 class="card-header text-center bg-dark">Recollection Schedules</h4>

				<div class="card-body">
					<div id="table" class="table-editable">

					<div class = "margin-below">
						<div class = "text-center">
					<!-- Add and Delete button-->
					<!--	<button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#importScheduleModal">Import Schedule</button> -->
					<!--	<button type="button" class="btn btn btn-outline-danger btn-circle ">Delete Schedule</button> -->
						</div>
					</div>
						<!-- Add button Modal -->
						<div class="modal fade" id="importScheduleModal" tabindex="-1" role="dialog" aria-labelledby="importScheduleModal" aria-hidden="true">
							<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLongTitle">Import Schedule</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
									</div>

                  <form action="importSchedule.php" method="POST" enctype="multipart/form-data">
    								<div class="modal-body" style="padding-right: 5%; padding-left: 5%;">

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
    									<button type="submit" class="btn btn-primary" name="importSubmit2">Submit</button>
    									<button  type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
    								</div>
    								<!-- Modal footer ends here-->
    							</form>

								</div>
							</div>
						</div>
						<!-- End of add modal-->

							<br>

						<!-- Table starts here -->
						<form id = "delete" action="delete_sched.php" method="post" onSubmit="return delete_confirm_schedule();">
							<table id="data_table" class="table table-bordered table-responsive-sm table-striped text-center table-bordered table-hover">
								<thead>
									<tr class="cardcolor">
										<th> </th>
										<th>Date</th>
										<th>Course</th>
										<th>Year</th>
										<th>Venue</th>
										<th>Participants</th>
										<th>Status</th>
										<th>Download</th>
									</tr>
								</thead>
								<tbody id = "recollection_list">
							<?php
								$table_query = "SELECT schedule.sched_id, schedule.sched_date, course.course_name,
												schedule.venue ,schedule.sched_time_start, schedule.sched_time_end, count(student_attendance.sched_id) as participants,schedule.`year_level`  FROM schedule
												INNER JOIN COURSE
												ON course.course_id = schedule.course_id
												LEFT JOIN student_attendance
												ON schedule.sched_id = student_attendance.sched_id
												GROUP BY schedule.sched_id
												ORDER BY sched_date DESC";

								$result = mysqli_query($conn,$table_query);
								while($row = mysqli_fetch_array($result) ){
									$participants = $row['participants'];
											$sched_id = $row['sched_id'];
									echo '<tr class ="table-row" data-href="pages/Schedule.php?ID='.$sched_id.'" value ="'.$sched_id.'">
											  <td><input type="checkbox" name="checkbox[]" class="checkbox" value = "'.$sched_id.'"/></td>
											  <td>'.$row['sched_date'].'</td>
											  <td>'.$row['course_name'].'</td>
											  <td>'.$row['year_level'].'</td>
											  <td>'.$row['venue'].'</td>
											  <td>'.$row['participants'].'</td>';
								?>
						</form>

						<form method="post" action="download_sched.php">
								<?php
									 date_default_timezone_set('Asia/Manila');
									 $schedule_date = $row['sched_date'];
									 $current_date = date('Y-m-d');
									 $current_time = date('h:i:s A');
									 $sched_time_end =$row['sched_time_end'];

                   if($participants <= 0){
                    echo  '<td class="text-success"> Pending </td>';
                  }elseif($participants >= 1){
                    echo  '<td class="text-danger"> Done </td>';
                  }
									/* if($schedule_date > $current_date){
										echo  '<td class="text-success"> Ongoing </td>';
									}elseif($schedule_date == $current_date AND $current_time < $sched_time_end){
										echo  '<td class="text-success"> Now </td>';
									}else{
										echo '<td class="text-danger"> Done </td>';
									}*/
										// Download Schedule Button
										echo  '<td><button type="submit" class="btn btn-outline-primary btn-sm" name="download" value ="'.$sched_id.'" />Download</button></td></tr>';
                  }
								?>
							</tbody>
						</form>
							<div class = "text-center mb-2">
								<!-- Add and Delete button  name="submit" value = "submit"-->
								<button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#importScheduleModal">Import Schedule</button>
								<button type="submit" class="btn btn-outline-danger btn-circle" class="btn btn-danger" form = "delete">Delete Schedule</button>
							</div>

						</table>
					</div>
				</div>
			</div>
		</header>

		<footer class="card-footer bg-primary">
			  <div class="footer-copyright text-center py-3">© Saint Louis University Recollection Website</div>
		</footer>

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/popper.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/datatables.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {;

		//DataTable Javascript Library
		$('#data_table').DataTable();


		//Table Row functionality
		$(".table-row").click(function (e) { // Makes the entire table row clickable
			if ($(e.target).is("input,button")) { // ignores checkbox and downloadbutton to be redirected to the schedule page.
				return true;
			}else{
			 window.open($(this).data("href")); // redirects to the schedule page.
			}
		});

		//Dynamic Drop Download
		$('#school').on('change', function(){
			var school_id = $(this).val();
			if(school_id){
				$.ajax({
					type:'POST',
					url:'ajaxDropdown.php',
					data:'school_id='+school_id,
					success:function(data){
						$('#course').html(data);
					}
				});
			}else{
				$('#course').html('<option value="">Select school first</option>');
			}
		});

		//Filter functionality through dropdown menu
		$('#term').on('click', function(){
			var school = document.getElementById('school').value;
			var course = document.getElementById('course').value;
			//var acad_year = document.getElementById('academic_year').value;
			$.ajax({
				url: 'recollectionTable.php',
				type: 'POST',
				data: {school: school, course: course},
					success: function(data){
						$('#recollection_list').html(data);
						console.log(school);
						console.log(course);
					},
					error: function(e){
						alert('There was an error. Reload and wait for 5 seconds.');
					}
			});
		});
	});
		</script>
	</body>
</html>
