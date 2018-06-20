<?php

//File that username availabilty and returns data to register.js

if(!isset($_SESSION)){ 
    session_start(); 
}

include_once("connect.php");

$tablename = "user";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE Scheduler;";
	$conn->query($sql);

	$username = $_POST["username"];

	$sql = "SELECT * FROM $tablename WHERE username = '$username';";
	$result = $conn->query($sql);	

	if($result->num_rows>0){
		echo ("Username is taken!");
	}	
	else{
		echo ("Username is available!");
	}

}	

?>