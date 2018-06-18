<?php

session_start();
$_SESSION['message']="";
include_once("connect.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

include_once("createDataTable.php");

$username = $_SESSION["username"];
$tablename = $username."appointments";

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Appointments | Scheduler</title>
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		
		html,body{
			margin: 0;
			padding: 0;
			background: #1A1A1D;
			font-family: 'Sofia';
		}

		.sidenav {
		    height: 100%;
		    width: 14vw;
		    z-index: 1;
		    position: fixed;
		    top: 1.1vh;
		    left: 0;
		    background-color: #111111;
		    overflow-x: hidden;
		    padding-top: 1.97vh;
		    
		}

		.sidenavlinks{
			font-family: 'Sofia';
		}

		.sidenav a{
		    padding: 6px 8px 6px 16px;
		    text-decoration: none;
		    font-size: 25px;
		    color: #818181;
		    display: block;
		}

		.sidenav a:hover{
		    color: #f1f1f1;
		}

		.title{
			font-family: 'Sofia';
			letter-spacing: 0.4em;
			font-size: 2em;
			padding: 5px;
		}

		.main{
			margin-top: 50px;
		    margin-left: 240px;
		    padding: 0px 10px;
		}

		.topnav{
		    background-color: #111111;
		    overflow: hidden;
		}

		.topnav a{
		    float: left;
		    display: block;
		    z-index: 1;
		    color: #f2f2f2;
		    text-align: center;
		    padding: 0px 16px;
		    text-decoration: none;
		    font-size: 17px;
		}

		.topnav a:hover{
		    background-color: yellow;
		    color: black;
		}

		.sticky{
			z-index: 1;
			position: fixed;
			top: 0;
			width: 100%
		}

		.sticky + .content{
 			padding-top: 60px;
		}

		.active{
		    background-color: yellow;
		    color: black;
		}

		.tableClass,tr{
			color: white;
		}

		#prevbtnId,#nextbtnId{
			color: white;
			font-size: 40px;
		}

		table{
			table-layout: auto;
    		border-radius: 10px;
    		margin-left: 3%;
    		box-shadow: 0 1px 2px 0 rgba(255,255,255,.55);
		}

		td{
			overflow: hidden;
			padding: 10px;
			text-align: center;
			cursor:pointer;
		}

		th{
			overflow: hidden;
			text-align: left;
			padding: 10px;
			padding-left: 5px;
		}

		thead th{
			box-shadow: none;
			font-size: 1.6em;
			border: 0;
			border-style: hidden;
		}

		.month{
			cursor:pointer;
		}

		#prevbtnId{
			float: left;
		}

		#nextbtnId{
			float: right;
		}

		@media screen and (max-height: 450px) {
		    .sidenav {
		    	padding-top: 15px;
		    }
		    .sidenav a{
		    	font-size: 18px;
		    }
		}

	</style>
</head>
<body>
	<div id="navbar" class="topnav">
		<a onclick="home()"><h2 class="title">Scheduler</h2></a>
	</div>
	<div><?= $_SESSION['message'] ?></div>
	<div class="sidenav" id="sidenavId">
		<a class="home sidenavlinks" onclick="home()">Home</a>
		<a id="appLinkId" class="sidenavlinks active" onclick="appointments()">Appointments</a>
		<a class="sidenavlinks" onclick="logout()">Logout</a>
	</div>	
	<div class="main" class="tableDivClass">
		<table class="tableClass" border="1">
			<thead class="month"> 
				<th id="prevbtnId" class="prev" colspan="1">&#10094;</th>
				<th id="monthDisplay" colspan="3" style="text-align: center;"></th>
				<th id="yearDisplay" colspan="2" style="text-align: center;"></th>
				<th id="nextbtnId" class="next" colspan="1">&#10095;</th>
			</thead>
			<tbody>
				<tr id="tr0">
					<th>Sun</th>
					<th>Mon</th>
					<th>Tue</th>
					<th>Wed</th>
					<th>thu</th>
					<th>Fri</th>
					<th>Sat</th>
				</tr>
				<tr id="tr1">
					<td id="tr1td0"></td>
					<td id="tr1td1"></td>
					<td id="tr1td2"></td>
					<td id="tr1td3"></td>
					<td id="tr1td4"></td>
					<td id="tr1td5"></td>
					<td id="tr1td6"></td>
				</tr>
				<tr id="tr2">
					<td id="tr2td0"></td>
					<td id="tr2td1"></td>
					<td id="tr2td2"></td>
					<td id="tr2td3"></td>
					<td id="tr2td4"></td>
					<td id="tr2td5"></td>
					<td id="tr2td6"></td>
				</tr>
				<tr id="tr3">
					<td id="tr3td0"></td>
					<td id="tr3td1"></td>
					<td id="tr3td2"></td>
					<td id="tr3td3"></td>
					<td id="tr3td4"></td>
					<td id="tr3td5"></td>
					<td id="tr3td6"></td>
				</tr>
				<tr id="tr4">
					<td id="tr4td0"></td>
					<td id="tr4td1"></td>
					<td id="tr4td2"></td>
					<td id="tr4td3"></td>
					<td id="tr4td4"></td>
					<td id="tr4td5"></td>
					<td id="tr4td6"></td>
				</tr>
				<tr id="tr5">
					<td id="tr5td0"></td>
					<td id="tr5td1"></td>
					<td id="tr5td2"></td>
					<td id="tr5td3"></td>
					<td id="tr5td4"></td>
					<td id="tr5td5"></td>
					<td id="tr5td6"></td>
				</tr>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		
		document.getElementById("sidenavId").style.top = document.getElementById("navbar").offsetHeight+"px";

		window.onscroll = function() {myFunction()};

		var navbar = document.getElementById("navbar");

		var sticky = navbar.offsetTop;

		function myFunction() {
		  if (window.pageYOffset >= sticky) {
		    navbar.classList.add("sticky")
		  } else {
		    navbar.classList.remove("sticky");
		  }
		}

	</script>
<script src="functions.js"></script>	
<script src="appointments.js"></script>
</body>
</html>