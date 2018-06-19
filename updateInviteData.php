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

	$sql = "UPDATE $tablename SET Checked='$checked', TaskText='$taskText', Starred='$starred', EditTime='$editTime' WHERE TaskNumber = $taskNumber;";
			$result = $conn->query($sql);

	$sql = "UPDATE $tablename SET Status='$status' WHERE id=$id;";
	$result = $conn->query($sql);

	if (!$result){
		trigger_error('Invalid query: ' . $conn->error);
	}	
		
}

?>