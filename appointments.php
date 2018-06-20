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

		.tableClass,tr{
			color: white;
		}

		#prevbtnId,#nextbtnId{
			color: orange;
			font-size: 40px;
		}

		#monthDisplay,#yearDisplay{
			color: orange;
		}

		table{
			table-layout: auto;
    		border-radius: 10px;
    		margin-left: 17%;
    		box-shadow: 0 1px 2px 0 rgba(255,255,255,.55);
    		background-color: #fff;
		}

		td{
			overflow: hidden;
			padding: 10px;
			text-align: center;
			cursor:pointer;
			border-radius: 5px;
			color: #333;
		}

		.trDateClass{
			font-weight: 900;
		}

		th{
			overflow: hidden;
			text-align: left;
			padding: 10px;
			padding-left: 5px;
			font-weight: 900;
			color: darkblue;
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

		.modal{
		    display: none;
		    position: fixed;
		    z-index: 1;
		    padding-top: 27vh;
		    left: 0;
		    top: 0;
		    width: 100%;
		    height: 100%;
		    overflow: auto;/* Enable scroll if needed */
		    background-color: rgb(0,0,0); /* Fallback color */
		    background-color: rgba(0,0,0,0.4);
		}

		.modal-content{
			overflow: auto;
		    position: relative;
		    background-color: #fefefe;
		    margin: auto;
		    padding: 0;
		    border-radius: 10px;
		    width: 38%;
		    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
		    -webkit-animation-name: animatetop;
		    -webkit-animation-duration: 0.4s;
		    animation-name: animatetop;
		    animation-duration: 0.4s
		}

		@-webkit-keyframes animatetop {
		    from{top:-300px; opacity:0} 
		    to {top:0; opacity:1}
		}

		@keyframes animatetop {
		    from {top:-300px; opacity:0}
		    to {top:0; opacity:1}
		}

		.close{
		    color: white;
		    float: right;
		    font-size: 28px;
		    font-weight: bold;
		}

		.close:hover,.close:focus{
		    color: #000;
		    text-decoration: none;
		    cursor: pointer;
		}

		.modal-header{
			border-radius: 10px;
		    padding: 2px 16px;
		    background-color: orange;
		    color: white;
		}

		.modal-body{
			padding: 2px 16px;
		}

		.inputClass{
			width: auto;
			height: auto;
		}

		#titleInputId{
			min-width: 100%;
			min-height: 40px;
			max-width: 100%;
			margin-top: 20px;
			margin-bottom: 10px;
			border-radius: 3px;
			font-family: "Comic Sans MS";
			font-size: 2em;
		}

		#descInputId{
			min-width: 100%;
			min-height: 100px;
			max-width: 100%;
			margin-top: 20px;
			margin-bottom: 20px;
			border-radius: 3px;
			font-family: "Georgia";
			font-size: 1.2em;
			vertical-align: top;
		}

		#inviteTextSpan{
			font-size: 1.1em;
		}

		#inviteInputId{
			border-radius: 3px;
			font-family: "Comic Sans MS";
			font-size: 1.1em;
			margin-top: 10px;
			margin-bottom: 20px;
		}

		#submitInputId{
			margin-top: 25px;
			margin-bottom: 10px;
			margin-left: 48%;
			border-radius: 3px;
			font-family: "Sofia";
			font-size: 1.2em;
		}

		.flex-container{
			display: flex;
			flex-direction: row;
		}

		.todaysEventsClass{
			min-width: 40vw;
			border-style: outset;
			border-radius: 10px; 
			padding: 0;
		}

		li{
			list-style-type: none;	
		}

		.tdyLiClass{
			padding-left: 20px;
			padding-right: 20px; 
		}

		.tdyLiClass:hover{
			transform: scale(1.05);
		}

		.tdyHeader{
			background-color: #01FF70;
			font-family: "Comic Sans MS";
			font-size: 1.5em;
			padding: 5px;
		}

		#tdyTextId{
			font-family: "Sofia";
			font-size: 1.2em;
			padding: 7px;
			margin-right: 30px;
		}

		.tdyTitleClass{
			margin-top: 20px;
			border-radius: 5px;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;
		    padding: 2px 16px;
		    background-color: orange;
		    color: white;
		    font-family: "Comic Sans MS";
		    font-size: 1.7em;
		}

		.tdyBodyClass{
			overflow: auto;
			min-height: 50px;
			font-family: "Trebuchet MS";
			border-bottom-left-radius: 5px;
			border-bottom-right-radius: 5px;
		    padding: 2px 16px;
		    background-color: #fff;
		    color: #111;
		}

		.tdyDescClass{
			margin-top: 10px;
			margin-bottom: 10px;
			font-size: 1.3em;
		}

		.tdyTimingsClass{
			font-family: "Trebuchet MS";
			font-style: italic;
			margin-top: 40px;
			font-weight: 600;
			font-size: 0.9em;
		}

		.tdyToClass{
			margin-left: 10px;
		}

		#tdyAppRegion{
			margin-bottom: 20px;
		}

		#clickHereId{
			font-family: "Sofia";
			font-size: 1.2em;
			color: yellow;
			text-align: center;
			padding-top: 30px;
			padding-bottom: 30px;
		}

		.inviteeSpanClass{
			border-style: outset;
			padding: 5px;
			font-family: "Trebuchet MS";
			margin-right: 10px;
			margin-left: 10px;
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
		<a id="appLinkId" class="sidenavlinks active" onclick="appointments()">Appointments</a>
		<a class="sidenavlinks" onclick="invites()">Invites</a>
		<a class="sidenavlinks" onclick="logout()">Logout</a>
	</div>	
	<div class="main"><?php echo $_SESSION['message'] ?></div>
	<div class="flex-container">
		<div class=" main tableDivClass">
			<table class="tableClass" border="1">
				<thead class="month"> 
					<th id="prevbtnId" class="prev" colspan="1"><i class="fa fa-chevron-circle-left"></i></th>
					<th id="monthDisplay" colspan="3" style="text-align: center;"></th>
					<th id="yearDisplay" colspan="2" style="text-align: center;"></th>
					<th id="nextbtnId" class="next" colspan="1"><i class="fa fa-chevron-circle-right"></i></th>
				</thead>
				<tbody>
					<tr id="tr0">
						<th id="tr0th0">Sun</th>
						<th id="tr0th1">Mon</th>
						<th id="tr0th2">Tue</th>
						<th id="tr0th3">Wed</th>
						<th id="tr0th4">Thu</th>
						<th id="tr0th5">Fri</th>
						<th id="tr0th6">Sat</th>
					</tr>
					<tr id="tr1" class="trDateClass">
						<td id="tr1td0"></td>
						<td id="tr1td1"></td>
						<td id="tr1td2"></td>
						<td id="tr1td3"></td>
						<td id="tr1td4"></td>
						<td id="tr1td5"></td>
						<td id="tr1td6"></td>
					</tr>
					<tr id="tr2" class="trDateClass">
						<td id="tr2td0"></td>
						<td id="tr2td1"></td>
						<td id="tr2td2"></td>
						<td id="tr2td3"></td>
						<td id="tr2td4"></td>
						<td id="tr2td5"></td>
						<td id="tr2td6"></td>
					</tr>
					<tr id="tr3" class="trDateClass">
						<td id="tr3td0"></td>
						<td id="tr3td1"></td>
						<td id="tr3td2"></td>
						<td id="tr3td3"></td>
						<td id="tr3td4"></td>
						<td id="tr3td5"></td>
						<td id="tr3td6"></td>
					</tr>
					<tr id="tr4" class="trDateClass">
						<td id="tr4td0"></td>
						<td id="tr4td1"></td>
						<td id="tr4td2"></td>
						<td id="tr4td3"></td>
						<td id="tr4td4"></td>
						<td id="tr4td5"></td>
						<td id="tr4td6"></td>
					</tr>
					<tr id="tr5" class="trDateClass">
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
		<div class="main todaysEventsClass" id="tdyEventId">
			<div id="tdyHeaderId1" class="tdyHeader">
				<span id="tdyTextId">Appointments</span>
				<span id="mmDisp"></span>
				<span id="yyyyDisp"></span>
			</div>
			<div id="tdyHeaderId2" class="tdyHeader">
				<span id="dayDisp"></span>
				<span id="ddDisp"></span>
			</div>
			<div id="tdyAppRegion"></div>
			<div id="clickHereId">Click here to add appointments</div>
		</div>
	</div>
	<div class="modal" id="modalId"> 
		<div class="modal-content">
			<div class="modal-header">
				<span class="close" id="modalCloseId">&times;</span>
				<h2 style="text-align: center; font-size: 1.8em;">Add appointment/event</h2>
				<div>
					<span>Date : </span>
					<input id="dateInputId" type="date" name="appDate">
				</div>
			</div>
			<div class="modal-body">		
					<div><input id="titleInputId" class="inputClass" type="text" name="title" placeholder="Add title"/></div>
					<div><input id="descInputId" class="inputClass" type="text" name="description" placeholder="Add description"/></div>
					<div>
						<span id="inviteTextSpan">Add Guests :</span>
						<input id="inviteInputId" type="text" name="invitee" placeholder="Username">
						<button id="inviteeAdd">Add</button>
					</div>
					<div id="inviteeAppendRegion"></div>
					<div style="text-align: center;">
						<span style="padding: 10px; font-family: Trebuchet MS;">From :</span><input id="appFromId" type="time" name="appFrom" value="10:30"/>
						<span style="padding: 10px; font-family: Trebuchet MS;">To :</span><input id="appToId" type="time" name="appTo" value="11:30"/>
					</div>	
					<div><input id="submitInputId" class="inputClass" type="submit" name="appAdd" value="Save" onclick="addAppointment();"></div>			
			</div>
		</div>
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

		var modal = document.getElementById('modalId');
		var close = document.getElementById("modalCloseId");
		var inviteeAppendRegion = document.getElementById("inviteeAppendRegion");

		close.onclick = function() {
		    modal.style.display = "none";
		    while(inviteeAppendRegion.firstChild){ //To remove the childs of Invitee username Region
    			inviteeAppendRegion.removeChild(inviteeAppendRegion.firstChild);
			}
			document.getElementById("titleInputId").value = "";
			document.getElementById("titleInputId").placeholder = "Add title";
			document.getElementById("descInputId").value = "";
			document.getElementById("descInputId").placeholder = "Add description";
			document.getElementById("inviteInputId").value = "";
			document.getElementById("inviteInputId").placeholder = "Username";
		}

		window.onclick = function(event) {
		    if (event.target == modal) {
		        modal.style.display = "none";
		    }
		}

	</script>
<script src="functions.js"></script>	
<script src="appointments.js"></script>
</body>
</html>