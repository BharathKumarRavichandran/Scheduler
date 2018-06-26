<?php

session_start();
include_once('connect.php');
include_once("createDb.php");
$_SESSION['message']="";

$tablename = "user";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $sql = "USE Scheduler;";
    $conn->query($sql);

    $_SESSION['message']="";
    $allow=1;

    $url ='https://www.google.com/recaptcha/api/siteverify';
    include_once("config.php");//To include $privateKey variable which contains the secret key to Google reCaptacha's API

    $response = file_get_contents($url."?secret=".$privateKey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);

    if(!((isset($data->success))AND($data->success==true))){
        $_SESSION['message'] = 'Captcha Failed!';
        $allow=0;
    }

    $username = $conn->real_escape_string($_POST['username']);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['message'] = 'Please enter a valid E-Mail address!';
        $allow=0;
    }

    if(!preg_match("/^[a-zA-Z0-9_.-]*$/",$_POST['username'])) {
        $_SESSION['message'] = 'Your username can only contain letters, numbers, underscore, dash, point, no other special characters are allowed!';
        $allow=0;
    }

    $sql = "SELECT * FROM $tablename;";
    $result = $conn->query($sql);

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){

            if($row["username"]==$username){
                $_SESSION['message'] = 'Username already exists!';
                $allow=0;
            }

            if($row["email"]==$email){
                $_SESSION['message'] = 'E-Mail already exists!';
                $allow=0;
            }
        }
    }   

    if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,}$/",$_POST['password'])) {
        $_SESSION['message'] = 'Your password should contain minimum four characters, at least one letter and one number!';
        $allow=0;
    }


    if($allow==1){

    	//if two passwords are equal to each other
    	if($_POST["password"]==$_POST["confirmpassword"]){

            $password = md5($_POST['password']); //md5 hash password for security

            //set session variables
            $_SESSION['username'] = $username; 
            $_SESSION['email'] = $email;

            include("createDataTable.php");

            //insert user data into database
            $stmt = $conn->prepare("INSERT INTO $tablename (username,email,password) "."VALUES (?,?,?)");
            if(!$stmt){
                echo "Error preparing statement ".htmlspecialchars($conn->error);
            }
            $stmt->bind_param("sss",$username,$email,$password);
            
            if($stmt->execute() === true){    
                $_SESSION['message'] = "Registration succesful! Added $username to the database!";
                header("location: home.php");  
    		}

            else{
               	$_SESSION['message'] = 'User could not be added to the database!';
            }

            $stmt->close();
            $conn->close();   

    	}

    	else{
            $_SESSION['message'] = 'Two passwords do not match!';
        }

    }    

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Sign Up | Scheduler</title>
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style type="text/css">
        
        html,body{
            margin: 0;
            padding: 0;
            background: #1A1A1D;
            font-family: 'Sofia';
        }

        .title{
            text-align: center;
            background: #111111;
            color: yellow;
            font-family: 'Sofia';
            letter-spacing: 0.4em;
            font-size: 4em;
            padding: 5px;
        }

        .tagline{
            text-align: center;
            color: yellow;
            font-family: 'Sofia';
            letter-spacing: 0.2em;
            font-size: 2em;
            padding: 5px;
            margin-bottom: 2%;
        }

        #registerTitle{
            text-align: center;
            color: orange;
            font-family: 'Sofia';
            letter-spacing: 0.4em;
            font-size: 2.5em;
            padding: 5px;
            padding-bottom: 0px;
        }

        #errMsg{
            overflow: auto;
            background: red;
            margin-top: -10px;
            letter-spacing: 0.1em;
            font-size: 1.1em;
            margin-left: 42.2vw;
            width: 14vw;
            padding: 3px;
            padding-left: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        #usernameIn{
            height: 20px;
            border-radius: 3px;
            margin: 10px;
            font-family: 'Trubuchet MS';
            letter-spacing: 0.1em;
            font-size: 1.3em;
            margin-left: 42vw;
        }

        #emailIn{
            height: 20px;
            border-radius: 3px;
            margin: 10px;
            font-family: 'Trubuchet MS';
            letter-spacing: 0.1em;
            font-size: 1.3em;
            margin-left: 42vw;
        }

        .passIn{
            height: 20px;
            border-radius: 3px;
            margin: 10px;
            font-family: 'Trubuchet MS';
            letter-spacing: 0.1em;
            font-size: 1.3em;
            margin-left: 42vw;
        }

        .reCaptchaClass{
            margin-left: 40.5vw;
            margin-top: 1vh;
            margin-bottom: 1vh;   
        }

        #submitIn{
            margin-top: 1%;
            border-radius: 3px;
            font-family: 'Sofia';
            letter-spacing: 0.3em;
            font-size: 1.1em;
            margin-left: 46.4vw;
            min-width: 7vw;
        }

        .options{
            margin-top: 5vh;
        }

        .text{
            font-family: 'Sofia';
            color: orange;
            font-size: 1.2em;
            margin-left: 40vw;
        }

        #loginb{
            border-radius: 3px;
            font-family: 'Sofia';
            letter-spacing: 0.3em;
            font-size: 1em;
            min-width: 7vw;
        }

        #foot{
            margin-top:5vh;
            color: white;
            text-align: center;
            font-size: 1.3em;
            letter-spacing: 4px;
        }

        #heart{
            color: red;
        }

        #nameLink{
            text-decoration: none;
            color: orange;
        }

    </style>
</head>
<body>
	<a onclick="#"><h1 class="title">Scheduler</h1></a>
    <div class="tagline">A web app to create and manage appointments</div>
    <h2 id="registerTitle">Sign Up</h2>
    <form action="register.php" method="post" autocomplete="off">
    	<div id="errMsg"><?= $_SESSION['message'] ?><span id="errMsg1"></span></div>
    	<div><input id="usernameIn" type="text" placeholder="Username" name="username" onkeyup="usernameAvailabilty(this.value);" onblur="usernameFocusOut();" required /></div>
	    <div><input id="emailIn" type="email" placeholder="Email" name="email" required /></div>
	    <div><input class="passIn" type="password" placeholder="Password" name="password" required /></div>
	    <div><input class="passIn" type="password" placeholder="Confirm Password" name="confirmpassword" required /></div>
        <div class="reCaptchaClass"><div class="g-recaptcha" data-sitekey="6Leo1F8UAAAAAP-J6ZC-lCOSjQ7TgJI6pDgdqsK1"></div></div>
	    <div><input id="submitIn" type="submit" value="Register" name="register"/></div>
    </form>
    <div class="options">
        <span class="text">Already have an account?</span>
        <span><button id="loginb" onclick="login()">Login</button></span>
    </div>
    <footer>
        <p id="foot">Made with <span id="heart">&hearts;</span> by <a id="nameLink" href="https://BharathKumarRavichandran.github.io">Bharath Kumar Ravichandran</a></p>
    </footer>
<script>

    function login(){
        window.location = "login.php";
    }

</script>
<script src="register.js"></script>       
</body>
</html>