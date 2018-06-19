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
		$inviteeStr = $_POST['inviteeStr'];
		$status = "Accepted";

		$sql = "INSERT INTO $tablename(AppointmentDate,Title,Description,FromTime,ToTime,Inviter,Invitee,Status) "."VALUES ('$appointmentDate','$title','$description','$fromTime','$toTime','$username','$inviteeStr','$status');";
		$result = $conn->query($sql);
		if (!$result){
			trigger_error('Invalid query: ' . $conn->error);
		}	

		$invitee = explode(" ", $inviteeStr);

		for($i=0;$i<count($invitee)-1;$i++){

			$status ="NYD";//Not Yet Decided
			$tablename1 = $invitee[$i]."appointments";
			$sql = "INSERT INTO $tablename1(AppointmentDate,Title,Description,FromTime,ToTime,Inviter,Invitee,Status) "."VALUES ('$appointmentDate','$title','$description','$fromTime','$toTime','$username','$invitee[$i]','$status');";
			$result = $conn->query($sql);
			
			if (!$result){
				trigger_error('Invalid query: ' . $conn->error);
			}	
		}

	}
		
}

?>