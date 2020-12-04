<?php
include "dbConfig.php";

//Fetching the Username and Password
$username = mysqli_real_escape_string($conn,$_POST['username']);
$password = mysqli_real_escape_string($conn,$_POST['password']);

if ($username != "" && $password != ""){
    $query = "select * from users where username='".$username."' and password='".$password."'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);

    if($row > 0){
        $_SESSION['username'] = $username ;
        echo true;
    }else{
        echo false;
    }

}