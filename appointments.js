var i=0;
var j=0;
var k=0;
var l=0;
var oldK=1;
var oldL=1;

var d;
var firstDay;
var day;
var date;
var month;
var year;
var currDay;
var currDate;
var currMonth;
var currYear;
var dd=1;
var mm;
var yyyy;
var dayStr = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
var monthStr = ["January","February","March","April","May","June","July","August","September","October","November","December"];

var inviteeStr = "";

var xmlhttp;
if (window.XMLHttpRequest) {
  		xmlhttp = new XMLHttpRequest();
} 
 else{
  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

var modal = document.getElementById("modalId");
var tdyAppRegion = document.getElementById("tdyAppRegion");

function initialise(){
	d = new Date();
	currDay = d.getDay();
	currDate = d.getDate();
	currMonth = d.getMonth();
	currYear = d.getFullYear();
	dd=1;
	mm=d.getMonth();
	yyyy=d.getFullYear();
	firstDay = new Date(yyyy,mm,dd).getDay();

	calendarInit(firstDay,1,currMonth,currYear);

	document.getElementById("mmDisp").innerHTML = monthStr[currMonth];
	document.getElementById("yyyyDisp").innerHTML = currYear;
	document.getElementById("dayDisp").innerHTML = dayStr[currDay];
	var q = ("0"+currDate).slice(-2);
	document.getElementById("ddDisp").innerHTML = q;

	var u = currDate;
	var v = currMonth+1;
	v = ("0"+v).slice(-2);
	var z = currYear;
	var appDate = z+"-"+v+"-"+u;

	getAppointmentData(appDate);

}

function getAppointmentData(appDate){
	
	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var params="appDate="+appDate;
	var data;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	data = JSON.parse(this.responseText);	
	    	for(i=0;i<data.length;i++){
	    		createAppBox(data[i].Title,data[i].Description,data[i].FromTime,data[i].ToTime);
	    	}	
	    }
	};
	xmlhttp.open("POST","getAppointmentData.php",true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function leapYearCheck(year){
	return (year%100===0)?(year%400===0):(year%4===0);
}

function endOfMonth(month,year){

	if(month==0||month==2||month==4||month==6||month==7||month==9||month==11){
		return 31;
	}	

	else if(month==3||month==5||month==8||month==10){
		return 30;
	}

	else if(month==1){
		if(leapYearCheck(year)==true){
			return 29;
		}
		else{
			return 28;
		}		
	}

}

function dayCalculator(firstDay){

	if(firstDay==0){
		return 0;
	}
	else if(firstDay==1){
		return 1;	
	}
	else if(firstDay==2){
		return 2;	
	}
	else if(firstDay==3){
		return 3;	
	}
	else if(firstDay==4){
		return 4;	
	}
	else if(firstDay==5){
		return 5;	
	}
	else if(firstDay==6){
		return 6;	
	}

}

function calendarInit(firstDay,date,month,year){

	l = dayCalculator(firstDay);

	document.getElementById("monthDisplay").innerHTML = monthStr[month];
	document.getElementById("yearDisplay").innerHTML = year;
	drawCalendar(l,date,month,year);

}

function dateClickHandler(){
	
	while(tdyAppRegion.firstChild){ //To remove the childs of Appointment Region
    	tdyAppRegion.removeChild(tdyAppRegion.firstChild);
	}

	k=this.getAttribute("id")[2];
	l=this.getAttribute("id")[5];
	this.style.backgroundColor = "#01FF70";
	document.getElementById("mmDisp").innerHTML = document.getElementById("monthDisplay").innerHTML;
	document.getElementById("yyyyDisp").innerHTML = document.getElementById("yearDisplay").innerHTML;
	document.getElementById("dayDisp").innerHTML = document.getElementById("tr0th"+l).innerHTML;
	var q = ("0"+document.getElementById("tr"+k+"td"+l).innerHTML).slice(-2);
	document.getElementById("ddDisp").innerHTML = q;
	var u = document.getElementById("ddDisp").innerHTML;
	var v = monthStr.indexOf(document.getElementById("mmDisp").innerHTML)+1;
	v = ("0"+v).slice(-2);
	var z = document.getElementById("yyyyDisp").innerHTML;
	var appDate = z+"-"+v+"-"+u;

	getAppointmentData(appDate);

	if(document.getElementById("tr"+oldK+"td"+oldL).style.backgroundColor!="initial"){
		if(document.getElementById("tr"+oldK+"td"+oldL).style.backgroundColor!="orange"){
			document.getElementById("tr"+oldK+"td"+oldL).style.backgroundColor = "initial";
		}
	}

	if(currMonth==monthStr.indexOf(document.getElementById("monthDisplay").innerHTML)&&document.getElementById("yearDisplay").innerHTML==currYear&&u==currDate){
		document.getElementById("tr"+k+"td"+l).style.background = "orange";
	}

	oldK=k;
	oldL=l;

}

function drawCalendar(l,date,month,year){

	for(j=1;j<6;j++){
		for(i=0;i<7;i++){
			document.getElementById("tr"+j+"td"+i).style.background = "none";
			document.getElementById("tr"+j+"td"+i).innerHTML = "";
			document.getElementById("tr"+j+"td"+i).style.backgroundColor = "initial";
			document.getElementById("tr"+j+"td"+i).removeEventListener("click",dateClickHandler,false);
		}
	}

	var num=1;
	var i=l;
	var j;

	for(j=1;j<6;j++){
		for(;i<7;i++){

			document.getElementById("tr"+j+"td"+i).innerHTML = num;

			if(month==currMonth&&year==currYear&&num==currDate){
				document.getElementById("tr"+j+"td"+i).style.background = "orange";
			}

			document.getElementById("tr"+j+"td"+i).addEventListener("click",dateClickHandler,false);

			num++;
			if(num>endOfMonth(month,year)){
				break;
			}
		}
		i=0;
	}

}

document.getElementById("prevbtnId").addEventListener("click",function(){

	dd=1;
	if(mm!=0){	
		mm--;
	}
	else{
		mm=11;
		yyyy--;
	}	

	firstDay = new Date(yyyy,mm,dd).getDay();
	calendarInit(firstDay,dd,mm,yyyy);

},false);

document.getElementById("nextbtnId").addEventListener("click",function(){

	dd=1;
	if(mm!=11){	
		mm++;
	}
	else{
		mm=0;
		yyyy++;
	}	

	firstDay = new Date(yyyy,mm,dd).getDay();
	calendarInit(firstDay,dd,mm,yyyy);

},false);

document.getElementById("clickHereId").addEventListener("click",function(event){

	inviteeStr = "";
	modal.style.display = "block";
	var u = document.getElementById("ddDisp").innerHTML;
	var v = monthStr.indexOf(document.getElementById("mmDisp").innerHTML)+1;
	v = ("0"+v).slice(-2);
	var z = document.getElementById("yyyyDisp").innerHTML;
	document.getElementById("dateInputId").value = z+"-"+v+"-"+u;

},false);

document.getElementById("inviteInputId").addEventListener("keyup",function(event){//Function to listen for enter keyup at InviteeInput

	if(event.keyCode==13){//enter keyCode
		if(document.getElementById("inviteInputId").value!=""){
			newInvitee();
		}	
	}

},false);

document.getElementById("inviteeAdd").addEventListener("click",function(event){

	if(document.getElementById("inviteInputId").value!=""){
		newInvitee();
	}	

},false);

function addAppointment(){

	var appDate = document.getElementById("dateInputId").value;
	var title = document.getElementById("titleInputId").value;
	var desc = document.getElementById("descInputId").value;
	var from = document.getElementById("appFromId").value;
	var to = document.getElementById("appToId").value;

	createAppBox(title,desc,from,to);
	addAppointmentDb(appDate,title,desc,from,to);

	document.getElementById("titleInputId").value = "";
	document.getElementById("titleInputId").placeholder = "Add title";
	document.getElementById("descInputId").value = "";
	document.getElementById("descInputId").placeholder = "Add description";
	document.getElementById("appFromId").value = "10:30";
	document.getElementById("appToId").value = "11:30";
	modal.style.display = "none";

	while(inviteeAppendRegion.firstChild){ //To remove the childs of Invitee username Region
    	inviteeAppendRegion.removeChild(inviteeAppendRegion.firstChild);
	}
}

function addAppointmentDb(appDate,title,desc,from,to){

	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url="saveAppointmentData.php";
	var purpose = "add";
	var params = "appDate="+appDate+"&title="+title+"&description="+desc+"&appFrom="+from+"&appTo="+to+"&inviteeStr="+inviteeStr+"&purpose="+purpose;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	console.log(this.responseText);		
	    }
	};
	xmlhttp.open('POST',url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function newInvitee(){

	var invitee = document.getElementById("inviteInputId").value;
	inviteeStr+=invitee+" ";

	var span = document.createElement("span");
	var spanText = document.createTextNode(invitee);

	span.appendChild(spanText);
	document.getElementById("inviteeAppendRegion").appendChild(span);

	span.setAttribute("class","inviteeSpanClass");

	document.getElementById("inviteInputId").value = "";
	document.getElementById("inviteInputId").placeholder = "Username";
}

function createAppBox(title,desc,from,to){

	var li = document.createElement("li");
	var titleDiv = document.createElement("div");
	var bodyDiv = document.createElement("div");
	var descDiv = document.createElement("div");
	var timingsDiv = document.createElement("div");
	var fromSpan = document.createElement("span");
	var toSpan = document.createElement("span");

	var titleText = document.createTextNode(title);
	var descText = document.createTextNode(desc);
	var fromText = document.createTextNode("From : "+from);
	var toText = document.createTextNode(" To : "+to);

	titleDiv.appendChild(titleText);
	descDiv.appendChild(descText);
	fromSpan.appendChild(fromText);
	toSpan.appendChild(toText);

	li.appendChild(titleDiv);
	bodyDiv.appendChild(descDiv);
	timingsDiv.appendChild(fromSpan);
	timingsDiv.appendChild(toSpan);
	bodyDiv.appendChild(timingsDiv);
	li.appendChild(bodyDiv);
	document.getElementById("tdyAppRegion").appendChild(li);

	li.setAttribute("class","tdyLiClass");
	titleDiv.setAttribute("class","tdyTitleClass");
	bodyDiv.setAttribute("class","tdyBodyClass");
	descDiv.setAttribute("class","tdyDescClass");
	timingsDiv.setAttribute("class","tdyTimingsClass");
	fromSpan.setAttribute("class","tdyFromClass");
	toSpan.setAttribute("class","tdyToClass");

}

initialise();