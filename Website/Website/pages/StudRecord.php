<?php
include '../dbConfig.php';

if(!isset($_SESSION['username'])){
    header('Location: ../Login.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: ../Login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<title>Student Record</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/font.css"/>
		<link rel="stylesheet" href="../fontawesome/css/all.min.css">
		<link rel="stylesheet" href="../css/style.css"/>
		<link rel="stylesheet" href="../css/datatable/datatables.min.css"/>
		<link rel="stylesheet" href ="../css/datatable/dataTables.bootstrap.min.css"/>
    <script type="text/javascript">
    // JQUERY Validation
      $(document).ready(function() {
          $("#frmCSVImport").on("submit", function () {

            $("#response").attr("class", "");
              $("#response").html("");
              var fileType = ".csv";
              var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
              if (!regex.test($("#file").val().toLowerCase())) {
                    $("#response").addClass("error");
                    $("#response").addClass("display-block");
                  $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
                  return false;
              }
              return true;
          });
      });
</script>
	</head>

	<body>
		<header>
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
						<li class ="nav-item active">
							<i class="fas fa-clipboard"></i>
							<a class="nav-link text-white" href="StudRecord.php">Student Record</a>
						</li>
						<li class ="nav-item">
							<i class="fas fa-chart-bar"></i>
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

			<div class = "header">
				<h1 class="text-center b-5"> Student Record </h1>
			</div>


	<div class="card mx-auto ">
		<div class="card-body">
			<div id="table" class="table-editable">
				<!-- Add and Delete button-->
				<div class = "margin-below">
					<div class="row">
						<div class="col-4">
							<label>ID number:</label>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Type...">
							</div>
						</div>
						
						<div class="col-4">
							<label>Last Name:</label>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Type...">
							</div>
						</div>

						<div class="col-4">
							<label>First Name:</label>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Type...">
							</div>
						</div>
					</div>
					<!-- Row ends here-->
					<div class="row">
						<div class="col-4">
							<label>School:</label>
							<div class="form-group">
								<select class="custom-select" id="school">
									<option disabled selected value="">Select School</option>
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

						<div class="col-4">
							<label>Course:</label>
							<div class="form-group">
								<select class="custom-select" id="course">
									<option disabled selected value="">Select School first</option>
								</select>
							</div>
						</div>
						
						<div class="col-4">
							<label>Year Level:</label>
							<div class="form-group">
								<select class="custom-select" id="year">
									<option disabled selected value="">Select Year</option>
									<?php
										$dropDown_query = "SELECT DISTINCT year from student_info ORDER BY year ASC";
										$result = mysqli_query($conn, $dropDown_query);
											while($row = mysqli_fetch_array($result)){
												echo '<option value= "'.$row['year'].'">'.$row['year'].'</option>';
											}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class = "text-center">
						<button type="button" class="btn btn-primary btn-circle" id="search">Search <i class="fas fa-search"></i></button>
					</div>




				<!-- Update Schedule Modal -->
					<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Import Students</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>

                <div id="response"
                    class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
                    <?php if(!empty($message)) { echo $message; } ?>
                </div>

							<!-- Modalbody starts here-->
							<form method="POST" action="import_students.php" enctype="multipart/form-data">
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

								</div>
								<!-- Modal footer starts here-->
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary" name="csv_upload_btn">Submit</button>
									<button  type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
								</div>
								<!-- Modal footer ends here-->
							</form>

							</div>
						</div>
					</div>

        <div class="container" >
			<div class = "margin-below">
				<div class = "text-center">
					<button type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#updateModal">Import Students</button>
				</div>
			</div>

			<br>

            <!-- Modal -->
            <div class="modal fade" id="modal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
						  <h5 class="modal-title">Student Recollection History</h5>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
                        </div>

                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                          <type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

						<table id = "data_table" class="table table-bordered table-responsive-sm table-striped text-center" cellspacing ="0" width="100%">
						 <thead>
							<tr class="cardcolor">
							  <th>I.D number</th>
							  <th>Last Name</th>
							  <th>First Name</th>
							  <th>Course</th>
							  <th>Year</th>
							  <th>Gender</th>
							  <th>1</th>
							  <th>2</th>
							  <th>3</th>
							  <th>4</th>
							</tr>
						  </thead>
						  <tbody id="student-list">
						   <?php
							$query = "SELECT student_info.id_number, student_info.lname, student_info.fname, student_info.course,
									  MAX(student_info.year) as year,student_info.gender,student_history.`1st_year`,student_history.`2nd_year`,student_history.`3rd_year`,student_history.`4th_year`
									  FROM student_info
									  INNER JOIN student_history
									  ON student_info.id_number = student_history.id_number
									  GROUP BY lname ORDER by student_info.id_number ASC";
							$result = mysqli_query($conn,$query);
							while($row = mysqli_fetch_array($result)){
								$id = $row['id_number'];
							?>
								<tr class='student_info' data-id= <?php  echo $id; ?>>
									<td><?php echo $row['id_number'];?></td>
									<td><?php echo $row['lname'];?></td>
									<td><?php echo $row['fname'];?></td>
									<td><?php echo $row['course'];?></td>
									<td><?php echo $row['year'];?></td>
									<td><?php echo $row['gender'];?></td>
									<td><?php echo $row['1st_year'];?></td>
									<td><?php echo $row['2nd_year'];?></td>
									<td><?php echo $row['3rd_year'];?></td>
									<td><?php echo $row['4th_year'];?></td>
								</tr>
							<?php }	?>
   						  </tbody>
						</table>
					</div>
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
		<!--<script type="text/javascript" src="../js/datatables.min.js"></script> -->
		<script type="text/javascript" src="../js/script.js"></script>
		<script type='text/javascript'>
            $(document).ready(function(){
				
				$('#school').on('change', function(){
					var school_id = $(this).val();
					if(school_id){
						$.ajax({
							type: 'POST',
							url: '../ajaxDropdown.php',
							data: 'school_id='+school_id,
							success: function(data){
								$('#course').html(data);
							}
						});
					}else{
						$('#course').html('<option value="">Select School first</option>');
					}
				});

                $('.student_info').click(function(){

                    var id_number = $(this).data('id');

                    // AJAX request
                    $.ajax({
                        url: 'ajaxfile.php',
                        type: 'post',
                        data: {id_number: id_number},
                        success: function(response){
                            // Add response in Modal body
                            $('.modal-body').html(response);

                            // Display Modal
                            $('#modal').modal('show');
                        }
                    });
                });
				
				$('#search').click(function(){
					var school = document.getElementById('school').value;
					var course = document.getElementById('course').value;
					var year = document.getElementById('year').value;
					$.ajax({
						url: 'studRecordTable.php',
						type: 'POST',
						data: {school: school, course: course, year: year},
						success: function(data){
							$('#student-list').html(data);
							console.log(school);
							console.log(course);
							console.log(year);
						},
						error: function(e){
							alert('There was an error. Reload and wait for 5 seconds');
						}
					});
				});
            });
            </script>

	</body>
</html>
