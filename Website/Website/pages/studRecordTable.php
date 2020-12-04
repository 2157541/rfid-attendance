<?php
	include_once '../dbConfig.php';
	$get_studentList = "select a.id_number, a.lname, a.fname, a.course, a.year, a.gender,
						d.`1st_year`,d.`2nd_year`,d.`3rd_year`,d.`4th_year`
						from student_info a join course b on a.course = b.course_name
						join school c on b.school_id = c.school_id
						join student_history d on a.id_number = d.id_number 
						where b.school_id=? and b.course_id=? and a.year=?
						order by a.id_number";
	$studentList_conn = $conn->prepare($get_studentList);
	$studentList_conn->bind_param('sss',$_POST['school'],$_POST['course'],$_POST['year']);
	$studentList_conn->execute();
	$result = $studentList_conn->get_result();
	$studentList_conn->close();
	while($row = mysqli_fetch_assoc($result)){
		$id = $row['id_number'];
?>
		<tr class="student-list" data-id= <?php echo $id; ?>>
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
	<?php } ?>


<script>
$('.student-list').click(function(){
	var id_number = $(this).data('id');
	
	$.ajax({
		url: 'ajaxfile.php',
		type: 'post',
		data: {id_number: id_number},
		success: function(response){
			$('.modal-body').html(response);
			$('#modal').modal('show');
		}
	});
});
</script>