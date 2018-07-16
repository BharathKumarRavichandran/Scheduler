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

	$notification = "seen";

	$stmt = $conn->prepare("SELECT * FROM $tablename WHERE Invitee = ? AND Status = ? AND Notification = ?;");
	if(!$stmt){
		echo "Error preparing statement ".htmlspecialchars($conn->error);
	}
	$stmt->bind_param("sss",$username,$status,$notification);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	$userInviteData = array();

	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){

			$r = array('ID'=>$row["id"],'AppointmentDate'=>$row["AppointmentDate"],'Title'=>$row["Title"],'Description'=>$row["Description"],'FromTime'=>$row["FromTime"],'ToTime'=>$row["ToTime"],'Inviter'=>$row["Inviter"],'Invitee'=>$row["Invitee"],'Status'=>$row["Status"],'Notification'=>$row['Notification']);

			array_push($userInviteData,$r);	
		}
	}	
	echo json_encode($userInviteData);
}	

?>