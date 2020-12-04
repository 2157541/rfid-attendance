<?php 
// Include the database config file 
include_once 'dbConfig.php'; 
 
if(!empty($_POST["school_id"])){ 
	$query = "SELECT * FROM course WHERE school_id = ".$_POST['school_id']." ORDER BY course_name ASC"; 
    $result = $conn->query($query); 
     
    // Generates course options list to HTML
    if($result->num_rows > 0){ 
        echo '<option value="">Select course</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['course_id'].'">'.$row['course_name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">course not found</option>'; 
    } 
}
?>