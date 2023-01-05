<?php

include 'notes.php';
$link = getDb(); 

 $letezik=false;
 $hiba=false;
 $hibaj=false;
$created = false;

session_start();
 

if(isset($_SESSION['loginsuccess']))
{header('Location:home.php');}
if (isset($_POST['emaillog']) && isset($_POST['pwdlog']) ) {
		// Set session variables
		$_SESSION["emaillogin"] = $_POST['emaillog'];
		$_SESSION["pwdlogin"] = $_POST['pwdlog'];

		$check="SELECT id FROM felhasznalo WHERE email = '$_POST[emaillog]'";
		$result = mysqli_query($link, $check);
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		$_SESSION["id"] = $row["id"];


	$check2="SELECT email FROM felhasznalo WHERE email = '$_POST[emaillog]'";
	$rs2 = mysqli_query($link, $check2);

	$check3="SELECT jelszo FROM felhasznalo WHERE jelszo = '$_POST[pwdlog]'";
	$rs3 = mysqli_query($link, $check3);
	if ($data = mysqli_fetch_array($rs2, MYSQLI_NUM))
		{
			  $hiba=false;
		}
		else{ $hiba=true;}
    if($data2 = mysqli_fetch_array($rs3, MYSQLI_NUM))
	{
		$hibaj=false;
	}
	else{$hibaj=true;}

	if($hiba==false && $hibaj==false && (isset($_SESSION['emaillogin']))){
		header('Location:home.php');
	}

}



if (isset($_POST['create'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['pwd']);

	$check="SELECT email FROM felhasznalo WHERE email = '$_POST[email]'";
	$rs = mysqli_query($link, $check);
	if ($data = mysqli_fetch_array($rs, MYSQLI_NUM))
		{
			  $letezik=true;
		}
	else{
    $createQuery = sprintf("INSERT INTO felhasznalo(email, nev, jelszo) VALUES ('%s', '%s', '%s')",
        $email,
        $name,
        $password
    );
    mysqli_query($link, $createQuery) or die(mysqli_error($link));
    $created = true;}
	}

?>
























<!DOCTYPE html>
	<html>
		<head>
			<title>Orange notes</title>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
		body {font-family: Bahnschrift;}

		.btn-outline-warning{color:#ffc107;background-color:transparent;background-image:none;border-color:#ffc107}.btn-outline-warning:hover{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-outline-warning.focus,.btn-outline-warning:focus{box-shadow:0 0 0 .2rem rgba(255,193,7,.5)}.btn-outline-warning.disabled,.btn-outline-warning:disabled{color:#ffc107;background-color:transparent}.btn-outline-warning:not(:disabled):not(.disabled).active,.btn-outline-warning:not(:disabled):not(.disabled):active,.show>.btn-outline-warning.dropdown-toggle{color:#212529;background-color:#ffc107;border-color:#ffc107}.btn-outline-warning:not(:disabled):not(.disabled).active:focus,.btn-outline-warning:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-warning.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(255,193,7,.5)}
		 .btn-outline-danger{color:#dc3545;background-color:transparent;background-image:none;border-color:#dc3545}.btn-outline-danger:hover{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-outline-danger.focus,.btn-outline-danger:focus{box-shadow:0 0 0 .2rem rgba(220,53,69,.5)}.btn-outline-danger.disabled,.btn-outline-danger:disabled{color:#dc3545;background-color:transparent}.btn-outline-danger:not(:disabled):not(.disabled).active,.btn-outline-danger:not(:disabled):not(.disabled):active,.show>.btn-outline-danger.dropdown-toggle{color:#fff;background-color:#dc3545;border-color:#dc3545}.btn-outline-danger:not(:disabled):not(.disabled).active:focus,.btn-outline-danger:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-danger.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(220,53,69,.5)}	
			
			p.a {
			font-family: "Bahnschrift";
				}
			p.b{
			text-align: center;
			    }
			p.c{
				color: #ffc107;
			}
			.footer{
				position: fixed;
				text-align: right;
				bottom: 5px;
				width: 88%;
			}
			.container2 {
			padding: 12px;
				}
			.alert {
			 padding: solid 20px;
			 background-color: #f44336;
			 color: white;
			 opacity: 1;
			 transition: opacity 0.6s;
			 margin-bottom: 15px;
					}
			.alert.warning {background-color: #ff9800;}
			.closebtn {
				margin-left: 15px;
				color: white;
				font-weight: bold;
				float: right;
				font-size: 22px;
				line-height: 20px;
				cursor: pointer;
				transition: 0.3s;
				}
				.closebtn:hover {
					color: black;
							}
			.mh1 div {
			height: 100vh;
			}
			
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
}



span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 30%;
    top: 10%;
    width: 40%; 
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    padding-top: 70px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #fecb6f;
    width: 80%; /* Could be more or less, depending on screen size */
	opacity: 80%
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }}
			

</style>
			

		
		</head>
	<body>

			<div class="container">
				<div class="page-header">
					<div class ="row">
					<div class="col-sm-6"><h1><a title="Homepage">
						<img src="orglogo.jpg" />
					</a></h1></div><div class="col-sm-3"></div> <div class="col-sm-2"> <h3><div class="text-right"> <p class="a"> <button onclick="document.getElementById('id01').style.display='block'"  class="btn btn-outline-warning">Log in</button> </p></div></h3> </div>
					</div>
				</div>  
			</div>
			
			<div id="id01" class="modal">
  
  <form class="modal-content animate" action="" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="orglogo.jpg" alt="Avatar" class="avatar">
    </div>

	<div class="container2">
    <div class="container2">
      <label for="uname"><b>Email:</b></label>
      <input type="text" class="form-control" placeholder="Enter Email" name="emaillog" required>
	  <?php if ($hiba): ?>
        <p>
            <span class="badge badge-danger">Hibás email cím!</span>
        </p>
        <?php endif; ?>
		</div>
		<div class="container2">
      <label for="psw"><b>Password:</b></label>
      <input type="password" class="form-control" placeholder="Enter Password" name="pwdlog" required>
        	  <?php if ($hibaj): ?>
        <p>
            <span class="badge badge-danger">Hibás jelszó!</span>
        </p>
        <?php endif; ?>
		</div>
		<div class="container2">
      <h3> <p class="a b" ><button type="submit" class="btn btn-outline-warning">Log in</button> </p>
		</div>
	  <label>
        <input type="checkbox" checked="checked" name="remember"> Keep me logged in
      </label>
    </div>



    <div class="container2" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn btn btn-outline-danger" >Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
			
			
			
			
			<div class="container">		
			<div class="row" >
			<div class="col-sm-6"> <img src="feher.jpg" class="img-responsive center-block" /> <img src="org.jpg" class="img-responsive center-block" /> <img src="feher.jpg" class="img-responsive center-block" /></div>
			<div class="col-sm-1"></div>
			<div class="col-sm-4">
				<h2> <div class="text-center"> <p class="a"> Register an account </p> </div> </h2>
				<form action="" method="post">
				<div class="col-xs-12">
					<div class="form-group">
						<p class="a"> <label for="nm">Name:</label> </p>
					<input type="name" required class="form-control" placeholder="Your name" id="nickname" name="name">
					</div>
					<div class="form-group">
						<p class="a"> <label for="email">Email address:</label> </p>
					<input type="email" required class="form-control" placeholder="Email address" id="email" name="email">
					</div>
					<div class="form-group">
						<p class="a"> <label for="pwd">Password:</label> </p>
					<input type="password" class="form-control" placeholder="Password min 8 character" id="pwd" name="pwd" pattern=".{8,}" title="A jelszónak minimum 8 karakterből kell állnia." required>
					</div>
					<div class="form-group">
						<p class="a"> <label for="re-pwd">Password again:</label> </p>
					<input type="password" required class="form-control" placeholder="Re-enter password" id="pwd-repeat">
					<p class="text-left a">By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
					</div >
					<?php if ($created): ?>
        <div class="alert warning">
		<p>
			<span class="closebtn">&times;</span>  
            Sikeres regisztráció!
        </p>
		</div>
        <?php endif; ?>

		<?php if ($letezik): ?>
		<div class="alert"
        <p>
           <span class="closebtn">&times;</span>
		   Az email cím már létezik!
        </p>
		</div>
        <?php endif; ?>
					<div class="col-xs-2"></div><p class="col-xs-8 a text-center"> <button type="submit" class="btn btn-outline-warning" name="create">Submit</button> </p>
					
					</div>
				</form>
				

			</div>
			</div>
			</div>

<script>
var password = document.getElementById("pwd")
  , confirm_password = document.getElementById("pwd-repeat");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("A két jelszó nem egyezik.");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;



var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
    close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}
</script>
</script>

<div class="fixed-bottom footer"><p class="c">About us<p></div>
	</body>
</html>

	  