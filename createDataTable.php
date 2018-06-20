<?php

if(!isset($_SESSION)){ 
    session_start(); 
}

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

include_once("connect.php");
$username = $_SESSION["username"];

$sql = "USE Scheduler;";
$conn->query($sql);

$tableName = $username."appointments";

$sql = "CREATE TABLE IF NOT EXISTS $tableName(
		id INT(100) NOT NULL AUTO_INCREMENT,
		AppointmentDate DATE NOT NULL,
		Title VARCHAR(500) NOT NULL,
		Description VARCHAR(500) NOT NULL, 
		FromTime TIME NOT NULL,
		ToTime TIME NOT NULL,
		Inviter VARCHAR(500),
		Invitee VARCHAR(500),
		Status VARCHAR(500),
		Notification VARCHAR(500),
		PRIMARY KEY (id,AppointmentDate)
		)";
$result = $conn->query($sql);

if (!$result) {
	trigger_error('Invalid query: ' . $conn->error);
}	

?>