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

function initialise(){
	getInviteData();
}

function getInviteData(){
	
	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var params="";
	var data;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	data = JSON.parse(this.responseText);	
	    	for(i=0;i<data.length;i++){
	    		createNotification(data[i].ID,data[i].AppointmentDate,data[i].FromTime,data[i].ToTime,data[i].Inviter);
	    	}	
	    }
	};
	xmlhttp.open("POST","getInviteData.php",true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function loadUnseenNotifications(){
	
	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var params="";
	var data;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	data = JSON.parse(this.responseText);	
	    	for(i=0;i<data.length;i++){
	    		createNotification(data[i].ID,data[i].AppointmentDate,data[i].FromTime,data[i].ToTime,data[i].Inviter);
	    	}	
	    }
	};
	xmlhttp.open("POST","getUnseenNotifications.php",true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function createNotification(id,appDate,from,to,inviter){

	var li = document.createElement("li");
	var div = document.createElement("div");
	var wordSpan = document.createElement("span");
	var inviterSpan = document.createElement("span");
	var wordSpan1 = document.createElement("span");
	var dateSpan = document.createElement("span");
	var wordSpan2 = document.createElement("span");
	var fromSpan = document.createElement("span");
	var wordSpan3 = document.createElement("span");
	var toSpan = document.createElement("span");
	var wordSpan4 = document.createElement("span");
	var acceptButton = document.createElement("button");
	var rejectButton = document.createElement("button");


	var inviterSpanText = document.createTextNode(inviter);
	var wordSpanText1 = document.createTextNode(" has sent you a meeting invite on ");
	var dateSpanText = document.createTextNode(appDate);
	var wordSpanText2 = document.createTextNode(" from ");
	var fromSpanText = document.createTextNode(from);
	var wordSpanText3 = document.createTextNode(" to ");
	var toSpanText = document.createTextNode(to);
	var wordSpanText4 = document.createTextNode(" ! ");
	var acceptButtonText = document.createTextNode("Accept");
	var rejectButtonText = document.createTextNode("Reject"); 

	inviterSpan.appendChild(inviterSpanText);
	wordSpan1.appendChild(wordSpanText1);
	dateSpan.appendChild(dateSpanText);
	wordSpan2.appendChild(wordSpanText2); 
	fromSpan.appendChild(fromSpanText);
	wordSpan3.appendChild(wordSpanText3);
	toSpan.appendChild(toSpanText); 
	wordSpan4.appendChild(wordSpanText4);  
	acceptButton.appendChild(acceptButtonText); 
	rejectButton.appendChild(rejectButtonText); 

	wordSpan.appendChild(inviterSpan);
	wordSpan.appendChild(wordSpan1);
	wordSpan.appendChild(dateSpan);
	wordSpan.appendChild(wordSpan2);
	wordSpan.appendChild(fromSpan);
	wordSpan.appendChild(wordSpan3);
	wordSpan.appendChild(toSpan);
	wordSpan.appendChild(wordSpan4);
	div.appendChild(wordSpan);
	div.appendChild(acceptButton);
	div.appendChild(rejectButton);
	li.appendChild(div);
	document.getElementById("notificationsRegion").appendChild(li);

	li.setAttribute("id","li"+id);
	acceptButton.setAttribute("id","Accept"+id);
	rejectButton.setAttribute("id","Reject"+id);

	li.setAttribute("class","main liNfClass");
	div.setAttribute("class","divNfClass");
	wordSpan.setAttribute("class","wordSpanNfClass");
	wordSpan1.setAttribute("class","wordSpanClass");
	wordSpan2.setAttribute("class","wordSpanClass");
	wordSpan3.setAttribute("class","wordSpanClass");
	wordSpan4.setAttribute("class","wordSpanClass");
	inviterSpan.setAttribute("class","inviterDataClass");
	dateSpan.setAttribute("class","inviterDataClass");
	fromSpan.setAttribute("class","inviterDataClass");
	toSpan.setAttribute("class","inviterDataClass");
	acceptButton.setAttribute("class","statusButton acceptBtnClass");
	rejectButton.setAttribute("class","statusButton rejectBtnClass");

	acceptButton.setAttribute("onclick","acceptInvite(this)");
	rejectButton.setAttribute("onclick","rejectInvite(this)");

}

function acceptInvite(y){

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("Accept");
    var k = parseInt(res[1]);
    var status = "Accepted";

    updateInvite(k,status);

    document.getElementById("li"+k).remove();

}

function rejectInvite(y){

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("Reject");
    var k = parseInt(res[1]);
    var status = "Rejected";

    updateInvite(k,status);

    document.getElementById("li"+k).remove();
    
}

function updateInvite(id,status){
	
	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url="updateInviteData.php";
	var params = "id="+id+"&status="+status;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	console.log(this.responseText);		
	    }
	};
	xmlhttp.open('POST',url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

initialise();

setInterval(loadUnseenNotifications,2000);