Element.prototype.remove = function() {  //Function written to remove element easily using .remove()
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

function home(){
	window.location = "home.php";
}

function appointments(){
	window.location = "appointments.php";
}

function invites(){
	window.location = "invites.php";
}

function logout(){
	window.location = "logout.php";
}