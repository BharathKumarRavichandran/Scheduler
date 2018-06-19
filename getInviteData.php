<?php

//File that gets user's invite data from database and returns to invites.js

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
$status = "NYD";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE Scheduler;";
	$conn->query($sql);

	$sql = "SELECT * FROM $tablename WHERE Invitee = '$username' AND Status = '$status';";
	$result = $conn->query($sql);	

	$userInviteData = array();

	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){

			$r = array('ID'=>$row["id"],'AppointmentDate'=>$row["AppointmentDate"],'Title'=>$row["Title"],'Description'=>$row["Description"],'FromTime'=>$row["FromTime"],'ToTime'=>$row["ToTime"],'Inviter'=>$row["Inviter"],'Invitee'=>$row["Invitee"],'Status'=>$row["Status"]);

			array_push($userInviteData,$r);	
		}
	}	
	echo json_encode($userInviteData);
}	

?>