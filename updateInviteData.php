<?php

//File that updates user's invites data in database from invites.js
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

	$id = $_POST['id'];
	$status = $_POST['status'];
	$notification = "seen";

	$stmt = $conn->prepare("UPDATE $tablename SET Status=?, Notification=? WHERE id=?;");
	if(!$stmt){
	    echo "Error preparing statement ".htmlspecialchars($conn->error);
    }
	$stmt->bind_param("ssi",$status,$notification,$id);
    $stmt->execute();
	$stmt->close();		
		
}

?>