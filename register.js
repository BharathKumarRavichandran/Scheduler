var i=0;
var j=0;
var k=0;

var xmlhttp;
if (window.XMLHttpRequest) {
	  	xmlhttp = new XMLHttpRequest();
} 
else{
 	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

function usernameAvailabilty(username){

	if(username!=""){
		var xmlhttp;
		if (window.XMLHttpRequest) {
		  		xmlhttp = new XMLHttpRequest();
		} 
		 else{
		  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var url="checkUsernameAvailability.php";
		var params = "username="+username;
		xmlhttp.onreadystatechange = function(){
		    if(xmlhttp.readyState==4&&xmlhttp.status==200){
		    	var availability=(xmlhttp.responseText);
		    	availability = availability.trim();
		    	if(availability=="Username is taken!"){
		    		document.getElementById("errMsg").style.background = "red";
		    		document.getElementById("errMsg1").innerHTML = availability;
		    	}
		    	else if(availability=="Username is available!"){
		    		document.getElementById("errMsg").style.background = "lightgreen";
		    		document.getElementById("errMsg1").innerHTML = availability;
		    	}
		    }
		};
		xmlhttp.open('POST',url,true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send(params);
	}	
}

function usernameFocusOut(){

	if(document.getElementById("errMsg1").innerHTML!="Username is taken!"){
		document.getElementById("errMsg").style.background = "red";
		document.getElementById("errMsg1").innerHTML = "";
	}	
}