<?php

//File that updates user's appointment data in database from appointment.js
if(!isset($_SESSION)){ 
    session_start(); 
} 

include_once("connect.php");
$_SESSION['message']="";

$username = $_SESSION["username"];
$tablename = $username."appointments";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE Scheduler;";
	$conn->query($sql);

	if($_POST["purpose"]=="add"){

		$appointmentDate = $_POST['appDate'];
		$title = $_POST['title'];
		$description = $_POST['description'];
		$fromTime = $_POST['appFrom'];
		$toTime = $_POST['appTo'];

		$sql = "INSERT INTO $tablename(AppointmentDate,Title,Description,FromTime,ToTime) "."VALUES ('$appointmentDate','$title','$description','$fromTime','$toTime');";
		$result = $conn->query($sql);
		if (!$result) {
			trigger_error('Invalid query: ' . $conn->error);
		}	
	}
		
}

?>