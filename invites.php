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
	<title>Invites | Scheduler</title>
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
			margin-top: 90px;
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

		.inviteTitle{
			margin-left: 40vw;
			margin-top: 20vh;
			font-size: 1.8em;
			color: yellow;
		}

		li{
			list-style-type: none;
		}

		.liNfClass{
			overflow: auto;
			background-color: orange;
			max-width: 54vw;
			min-height: 30px;
			margin-left: 27vw; 
			border-style: outset;
			border-radius: 3px;
			font-family: "Comic Sans MS";
			font-size: 1.3em;
			padding: 8px;
			margin-top: 10px;
			margin-bottom: 30px;
		}

		.liNfClass:hover{
			transform: scale(1.03);
		}

		.wordSpanClass{
			color: #111;
		}

		.inviterDataClass{
			font-weight: bold;
			font-style: italic;
			font-family: "Comic Sans MS";
		}

		.statusButton{
			border-radius: 2px;
			padding: 3px;
			margin: 5px;
			font-size: 0.7em;
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
	<div class="sidenav" id="sidenavId">
		<a class="home sidenavlinks" onclick="home()">Home</a>
		<a id="appLinkId" class="sidenavlinks" onclick="appointments()">Appointments</a>
		<a class="sidenavlinks active" onclick="invites()">Invites</a>
		<a class="sidenavlinks" onclick="logout()">Logout</a>
	</div>	
	<div class="main"><?php echo $_SESSION['message'] ?></div>
	<div class="main inviteTitle"><h2>Invite Notifications</h2></div>
	<div id="notificationsRegion"></div>

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
<script src="invites.js"></script>
</body>
</html>