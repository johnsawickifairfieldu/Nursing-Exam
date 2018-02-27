<?php  

ob_start();
session_start();

//require_once('config.php');
require_once("UserController.php");
$posted = true;
$existing = false;
$uc = new UserController();

if (isset($_POST['login']) && isset($_POST) && !empty($_POST)){

	$email = $_POST['email'];
	$password =  $_POST['password'];
	//check if user exists
	$result1  = $uc->ifUserExists( $email );			

	if($result1){
		$existing = true;
	}
	if($existing){
	$result  = $uc->validateLogin( $email , $password);	
	if(!$result){
	$fmsg = "Invalid Credentials.";
	$messageClass = "alert alert-danger";
	}
}
	else{
    $fmsg = "Invalid email";
	$messageClass = "alert alert-danger";
	}

}else{
	$posted = false;
	
}

if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])){

	echo "Welcome: " . $_SESSION['firstname'] ." ".$_SESSION['lastname']. "<br>";
	echo "You are logged into a session.<br>";
	echo "<a href='logout.php'>Logout</a>"; 
}else{

?>




<html lang = "en">   
	<head>
		<title>CT Nurse Training</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
<style type="text/css">
	
	body{
		
   /* background: linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url("https://unsplash.imgix.net/photo-1416339442236-8ceb164046f8?q=75&fm=jpg&s=8eb83df8a744544977722717b1ea4d09");*/
   background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url("http://www.cnatrainingclass.net/home/public_html/cnatngcls/wp-content/uploads/2014/09/bigstock-Female-nurse-working-her-job-i-66574453-1024x682.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    color: #fff;
    height: auto;
   width: auto;
	}
	.form-signin {
  max-width: 430px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
 
  background: linear-gradient(rgba(0,0,0,.1), rgba(0,0,0,.1)), #fff;
  border: 1px solid rgba(0,0,0,0.1);  
  border-radius: 9px;
}
  .form-signin-heading {
	  margin-bottom: 30px;
	}
</style>
		<body>     
		<!-- Fixed Navbar Top -->
			<nav class="navbar navbar-dark bg-danger navbar-fixed-top py-2">
				<div class="container-fluid">
					<div class="navbar-header">
						<a href="#" class="navbar-brand">CT Nurse Training Portal</a>
					</div>
					
					<a href="register.php" class="btn btn-success navbar-btn navbar-right ">Register</a>
				</div>
			</nav>


<div class="container-fluid">
	<!-- Welcome heading -->
	<div class="row mt-4 py-3">
		
		<div class="col-12 col-md-8 align-self-center">
			<h1 class="display2 py-md-5 ml-5">Welcome to CT Nurse Training Portal</h1>
		</div>

		<!--Login form with user email Id and password  -->
		<div class="col-12 col-md-4 mt-4 align-self-center">
			<form class="form-signin" role="form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
<?php
if(!empty($_GET['msg'])){
$fmsg = $_GET['msg'];
 $messageClass = "alert alert-success"; 
}
 ?>
      <?php if(isset($fmsg)){ ?><div class="<?php echo $messageClass; ?>"> <?php echo $fmsg; ?> </div><?php } ?>
				<div class="text-center mb-md-4">
					<h1 class="text-primary form-signin-heading"> Login here</h1>
				</div>
				<div class="form-label-group my-3">
					<label for="username" class="text-primary">Email Address</label>

					<input type="email" name="email" id="username" class="form-control" placeholder="Email address" required autofocus>
					
				</div>

				<div class="form-label-group my-3">
					<label for="inputPassword" class="text-primary">Password</label>
					<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
					
				</div>
				<div class="form-group my-2">
				<button class="btn btn-lg btn-success btn-block mt-4" name="login" type="submit">Sign In</button>
				<a href="forgotpassword.php">Forgot password...</a>
			</div>

			</form>
		</div>
	
	</div>
</div>

	</body>
</html>



<?php } ?>