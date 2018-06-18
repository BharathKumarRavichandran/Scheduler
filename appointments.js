var i=0;
var j=0;
var k=0;
var l=0;

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
var monthStr = ["January","February","March","April","May","June","July","August","September","October","November","December"];

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

function calendarInit(firstDay,date,month,year){

	if(firstDay==0){
		l=0;
	}
	else if(firstDay==1){
		l=1;	
	}
	else if(firstDay==2){
		l=2;	
	}
	else if(firstDay==3){
		l=3;	
	}
	else if(firstDay==4){
		l=4;	
	}
	else if(firstDay==5){
		l=5;	
	}
	else if(firstDay==6){
		l=6;	
	}

	document.getElementById("monthDisplay").innerHTML = monthStr[month];
	document.getElementById("yearDisplay").innerHTML = year;
	drawCalendar(l,date,month,year);

}

function drawCalendar(l,date,month,year){

	for(j=1;j<6;j++){
		for(i=0;i<7;i++){
			document.getElementById("tr"+j+"td"+i).style.background = "none";
			document.getElementById("tr"+j+"td"+i).innerHTML = "";
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

initialise();