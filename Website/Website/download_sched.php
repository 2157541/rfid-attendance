 <?php  
include_once 'dbConfig.php';

	 if(isset($_POST["download"])) { 
			$sched_id = $_POST["download"];
				
			$query ="SELECT DISTINCT course.course_name, schedule.year_level,schedule.sched_date
					 FROM schedule 
					 INNER JOIN COURSE 
					 ON course.course_id = schedule.course_id
					 WHERE schedule.sched_id='".$sched_id."'";
			//CSV Name Query
			$name_query = mysqli_query($conn,$query);
			
			//Mysql Data to Array
			$course_name = array();
			$year = array();
			$sched_date = array();
			
			//Collects the data in each row of the $name_query
			while ($row = mysqli_fetch_assoc($name_query)) {
				$course_name[] = $row['course_name'];	
				$year[] = $row['year_level'];
				$sched_date[] = $row['sched_date'];	  
			}
				
			//Array to String
			$filename_course = implode(',',$course_name);
			$filename_year = implode(',',$year);
			$filename_sched_date = implode(',',$sched_date);
				
			//CSV Filename 
			$filename = $filename_course. ' ' .$filename_year. ' ' . '('. $filename_sched_date. ')';
			header("Content-Type: text/csv; charset=utf-8");  
			header("Content-Disposition: attachment; filename=\"$filename.csv\"");  
			$output = fopen("php://output", "w");
				
			//CSV data query
			$query ="SELECT student_attendance.sched_id, student_attendance.id_number , student_info.lname, student_info.fname, student_info.course, student_info.year, student_info.gender,student_attendance.attendance_am, student_attendance.attendance_pm 
					from student_attendance
					INNER JOIN student_info
					ON student_attendance.id_number = student_info.id_number
					WHERE sched_id=" . $sched_id; 
			fputcsv($output, array('sched_id','id_number', 'lname', 'fname', 'course', 'year', 'gender', 'attendance_am', 'attendance_pm'));  
			   
			//Generates the data inside the CSV   
			$result = mysqli_query($conn, $query);  
			while($row = mysqli_fetch_assoc($result))  
			{  
				fputcsv($output, $row);  
			}  
			fclose($output);
		}
			
 ?>  