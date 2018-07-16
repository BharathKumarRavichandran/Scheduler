<?php

//File that updates user's appointment data in database from appointment.js
if(!isset($_SESSION)){ 
    session_start(); 
} 

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
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
		$notification = "seen";

		$stmt = $conn->prepare("INSERT INTO $tablename(AppointmentDate,Title,Description,FromTime,ToTime,Inviter,Invitee,Status,Notification) "."VALUES ('$appointmentDate',?,?,'$fromTime','$toTime',?,?,?,?);");
		if(!$stmt){
            echo "Error preparing statement ".htmlspecialchars($conn->error);
        }
        $stmt->bind_param("ssssss",$title,$description,$username,$inviteeStr,$status,$notification);
        $stmt->execute();
        $stmt->close();	

		$invitee = explode(" ", $inviteeStr);

		for($i=0;$i<count($invitee)-1;$i++){

			$status ="NYD";//Not Yet Decided
			$notification = "unseen";
			$tablename1 = $invitee[$i]."appointments";
			$stmt = $conn->prepare("INSERT INTO $tablename1(AppointmentDate,Title,Description,FromTime,ToTime,Inviter,Invitee,Status,Notification) "."VALUES ('$appointmentDate',?,?,'$fromTime','$toTime',?,?,?,?);");
			if(!$stmt){
	            echo "Error preparing statement ".htmlspecialchars($conn->error);
	        }
	        $stmt->bind_param("ssssss",$title,$description,$username,$invitee[$i],$status,$notification);
	        $stmt->execute();
			$stmt->close();
		}

	}
		
}

?>