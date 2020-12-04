<?php
include_once "../dbConfig.php";

if(!isset($_SESSION['username'])){
header('Location: Login.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: ../Login.php');
}
?>

<!DOCTYPE html>
<html>
   <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Recollection Statistic Page</title>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/font.css"/>
		<link rel="stylesheet" type="text/css" href="../fontawesome/css/all.min.css">
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<link rel="stylesheet" type="text/css" href="../css/datatable/datatables.min.css"/>
		<link rel="stylesheet" type="text/css" href ="../css/datatable/dataTables.bootstrap.min.css"/>
	</head>

	<body>
		<!-- Navigation bar starts here -->
		<nav class="navbar navbar-expand-lg ">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="logo">
					<img src="../pictures/Logo.png" class="img-responsive" alt="Logo">
			</div>


			<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
				<ul class="navbar-nav  ml-auto">
					<li class ="nav-item">
						<i class="fas fa-home"></i>
						<a class="nav-link text-white" href="../Home.php">Home</a>
					</li>
					<li class ="nav-item">
						<i class="fas fa-chart-bar"></i>
						<a class="nav-link text-white" href="StudRecord.php">Student Record</a>
					</li>
					<li class ="nav-item active">
						<i class="fas fa-clipboard"></i>
						<a class="nav-link text-white" href="Statistic.php">Statistic</a>
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
		</nav>
		<hr class="line">
		<!-- Navigation bar starts here -->


		<!-- Page Header -->
		<div class = "header">
			<h1 class="text-center b-5"> Recollection Statistics </h1>
		</div>

		<!-- Dropdown And Download -->
		<div class="card mx-auto ">
			<div class="card-body">
				<div id="table" class="table-editable">
					<div class = "margin-below">
						<div class="row">
							
						<div class="col-3">
							<label>School:</label>
							<div class="form-group" id="school">
								<select class="custom-select">
								<!--<option disabled="" selected=""> Select</option>-->
								<option>All</option>
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

						<div class="col-3">
							<label>Academic Year:</label>
							<div class="form-group">
								<select class="custom-select">
								<?php
										$dropDown_query = "SELECT DISTINCT(`academic_year`) as AY FROM `schedule`";
										$result = mysqli_query($conn, $dropDown_query);
										while($row = mysqli_fetch_array($result)){
											  echo '<option value="'.$row['AY'].'">'.$row['AY'].'</option>';
										}
								?>
								</select>
							</div>
						</div>

						<div class="mt-4">
								<button type="button" class="btn btn-primary">Download</button>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End -->

		<!-- Recollection Statistics Start-->
		<?php
			//Query that get data from the student history table
			$query = "SELECT
					  COUNT(IF(`student_info`.status = 'enrolled',1,NULL)) as Total_Students,
					  COUNT(IF(`student_info`.year = '1',1,NULL)) as Total_1st_year,
					  COUNT(IF(`student_info`.year = '2',1,NULL)) as Total_2nd_year,
					  COUNT(IF(`student_info`.year = '3',1,NULL)) as Total_3rd_year,
					  COUNT(IF(`student_info`.year = '4',1,NULL)) as Total_4th_year,
					  COUNT(IF(`1st_year` = 'Completed',1,NULL)) as attended_1st_year,
					  COUNT(IF(`2nd_year` = 'Completed',1,NULL)) as attended_2nd_year,
					  COUNT(IF(`3rd_year` = 'Completed',1,NULL)) as attended_3rd_year,
					  COUNT(IF(`4th_year` = 'Completed',1,NULL)) as attended_4th_year,
					  COUNT(IF(`1st_year` = 'Absent',1,NULL)) as absent_1st_year,
					  COUNT(IF(`2nd_year` = 'Absent',1,NULL)) as absent_2nd_year,
					  COUNT(IF(`3rd_year` = 'Absent',1,NULL)) as absent_3rd_year,
					  COUNT(IF(`4th_year` = 'Absent',1,NULL)) as absent_4th_year
					  FROM `student_history`
					  INNER JOIN student_info
					  ON student_history.id_number = student_info.id_number";

			$result = mysqli_query($conn,$query);

			//Loop through the returned data
			while ($row = mysqli_fetch_array($result)) {
				//Total of each Participants from Freshmen(1st year) to Senior(4th year)
				$Total_Freshmen  = $row['Total_1st_year'];
				$Total_Sophomore = $row['Total_2nd_year'];
				$Total_Junior    = $row['Total_3rd_year'];
				$Total_Senior    = $row['Total_4th_year'];
				//Attended Participants from Freshmen(1st year) to Senior(4th year)
				$Attended_Freshmen  = $row['attended_1st_year'];
				$Attended_Sophomore = $row['attended_2nd_year'];
				$Attended_Junior    = $row['attended_3rd_year'];
				$Attended_Senior    = $row['attended_4th_year'];
				//Absent Participants from Freshmen(1st year) to Senior(4th year)
				$Absent_Freshmen    = $row['absent_1st_year'];
				$Absent_Sophomore   = $row['absent_2nd_year'];
				$Absent_Junior      = $row['absent_3rd_year'];
				$Absent_Senior      = $row['absent_4th_year'];
			}
		?>

	    <div class="container">
			<canvas id="chart" class ="chart-style"></canvas>
			<script type="text/javascript" src="../js/jquery.min.js"></script>
			<script type="text/javascript" src="../js/popper.min.js"></script>
			<script type="text/javascript" src="../js/bootstrap.min.js"></script>
			<script type="text/javascript" src="../js/Chart.min.js"></script>
			<script>
				var ctx = document.getElementById("chart").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'bar',
		        data: {
		            labels: ['1st Year','2nd Year','3rd Year','4th Year'],
		            datasets:
		            [{
		                label: 'Total Students',
		                data: [<?php echo $Total_Freshmen ;?>,<?php echo $Total_Sophomore;?>,
							   <?php echo $Total_Junior;?>,<?php echo $Total_Senior;?>],
		                backgroundColor: '#1985b5',
		                borderColor:'#0c5f83',
		                borderWidth: 2
		            },

		            {
		            	label: 'Attended',
		                data: [<?php echo $Attended_Freshmen;?>,<?php echo $Attended_Sophomore;?>,
							   <?php echo $Attended_Junior;?>,<?php echo $Attended_Senior;?> ],
		                backgroundColor: '#8eff6a',
		                borderColor:'#5ca844',
		                borderWidth: 2
					},
					{
		            	label: 'Absent',
		                data: [<?php echo $Absent_Freshmen;?>,<?php echo $Absent_Sophomore;?>,
							   <?php echo $Absent_Junior;?>,<?php echo $Absent_Senior;?> ],
		                backgroundColor: '#ff529e',
		                borderColor:'#b5195d',
		                borderWidth: 2
		            }]
		        },
		     //Legend Style
		        options: {
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {fontColor: 'black', fontSize: 18}}
		        }
		    });
			</script>
	    </div>
	</body>
	<footer class="card-footer bg-primary">
		<div class="footer-copyright text-center py-3">© Saint Louis University Recollection Website
		</div>
	</footer>
</html>
