 <?php
    include_once 'dbConfig.php';
    date_default_timezone_set('Asia/Manila');
    $get_recollection = "select a.sched_id, a.sched_date as 'date', b.course_name, a.year_level, a.venue, count(d.sched_id) as Participants from schedule a join course b on a.course_id = b.course_id join school c on b.school_id = c.school_id join student_attendance d on a.sched_id = d.sched_id where c.school_id = ? and b.course_id = ? group by a.sched_id ORDER BY `a`.`sched_date`";
    $recollection_conn = $conn->prepare($get_recollection);
    $recollection_conn->bind_param('ss',$_POST['school'],$_POST['course']);
    $recollection_conn->execute();
    $result = $recollection_conn->get_result();
	$recollection_conn->close();
    $counter = 1;
    while($row = mysqli_fetch_assoc($result)){
		$sched_id = $row['sched_id'];
        echo '<tr class="table-row" data-href="pages/Schedule.php?ID='.$sched_id.'" value="'.$sched_id.'">';
        echo '<td><input type="checkbox" name="checkbox[]" class="checkbox" value = "'.$sched_id.'"/></td>';
        echo '<td>'.$row['date'].'</td>';
        echo '<td>'.$row['course_name'].'</td>';
        echo '<td>'.$row['year_level'].'</td>';
        echo '<td>'.$row['venue'].'</td>';
        echo '<td>'.$row['Participants'].'</td>';
?>
	<form method="post" action="download_sched.php">
	<?php
        $schedule_date = $row['sched_date'];
        $current_date = date('Y-m-d');
        $current_time = date('h:i:s A');
        $sched_time_end =$row['sched_time_end'];
        if($schedule_date > $current_date){
            echo  '<td class="text-success"> Ongoing </td>';
        }elseif($schedule_date == $current_date AND $current_time < $sched_time_end){
            echo  '<td class="text-success"> Now </td>';
        }else{
            echo '<td class="text-danger"> Done </td>';
        }
            echo  '<td><button type="submit" class="btn btn-outline-primary btn-sm" name="download" value ="'.$sched_id.'" />Download</button></td></tr>';
			$counter++;
		}
	?>		
	</form>
	
	<script>
	$(".table-row").click(function(e){
		if($(e.target).is("input,button")){
			return true;
		}else{
			window.open($(this).data("href"));
		}
	});
	</script>