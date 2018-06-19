<?php

//File that gets user's appointment data from database and returns to appointment.js

if(!isset($_SESSION)){ 
    session_start(); 
}

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

include_once("connect.php");

$username = $_SESSION["username"];
$tablename = $username."appointments";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE Scheduler;";
	$conn->query($sql);

	$appDate = $_POST['appDate'];
	
	$sql = "SELECT * FROM $tablename WHERE AppointmentDate = '$appDate';";
	$result = $conn->query($sql);	

	$userAppData = array();

	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){

			if($row["Status"]=="Accepted"){
				$r = array('AppointmentDate'=>$row["AppointmentDate"],'Title'=>$row["Title"],'Description'=>$row["Description"],'FromTime'=>$row["FromTime"],'ToTime'=>$row["ToTime"]);

				array_push($userAppData,$r);
			}	
		}
	}	
	echo json_encode($userAppData);
}	

?>