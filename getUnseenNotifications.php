<?php

//File that gets user's unseen invite data from database and returns to invites.js

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

	$notification = "unseen";

	$sql = "SELECT * FROM $tablename WHERE Invitee = '$username' AND Status = '$status' AND Notification = '$notification';";
	$result = $conn->query($sql);	

	$userInviteData = array();

	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){

			$notification = "seen";
			$sql = "UPDATE $tablename SET Notification='$notification' WHERE id=".$row['id'].";";
			$conn->query($sql);

			$r = array('ID'=>$row["id"],'AppointmentDate'=>$row["AppointmentDate"],'Title'=>$row["Title"],'Description'=>$row["Description"],'FromTime'=>$row["FromTime"],'ToTime'=>$row["ToTime"],'Inviter'=>$row["Inviter"],'Invitee'=>$row["Invitee"],'Status'=>$row["Status"],'Notification'=>$row['Notification']);

			array_push($userInviteData,$r);	

		}
	}	
	echo json_encode($userInviteData);
}	

?>