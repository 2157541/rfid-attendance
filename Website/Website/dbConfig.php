 <?php
 session_start();

/**
 *
 */
  $server = "localhost"; //servername
  $user = "root";		//username
  $pass = "";			//password
  $db = "recollection";		//database


  //Create connected to the server
  $conn = mysqli_connect($server, $user, $pass, $db);

  //Check connection
  if(mysqli_connect_error()){
 	echo "Failed to connect to the database:" , mysqli_connect_error();
  }
 ?>
