
<?php
session_start();
session_unset();
session_destroy();

function GUID()
{
	if (function_exists('com_create_guid') === true)
	{
		return trim(com_create_guid(), '{}');
	}

	return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

//require('config.php');
require_once("UserController.php");
$uc = new UserController();

$existing = false;
$success = false;
$posted = true;


if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password'])) {
	$guid = GUID();
	$email = $_POST['email'];
	$password = $_POST['password'];
	$firstname = $_POST['fname'];
	$lastname = $_POST['lname'];
	$school = $_POST['school'];
	$gradyear = $_POST['gyear'];
	$question1 = $_POST['ques1'];
	$answer1 = $_POST['ans1'];
	$question2 = $_POST['ques2'];
	$answer2 = $_POST['ans2'];

	if($question1 == $question2){
		$fmsg = "Choose different security questions";
		$messageClass = "alert alert-danger";
	}else{

        //check if user exists
		$result  = $uc->ifUserExists( $email );			

		if($result){
			$existing = true;
		}else{
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);
	        //insert user details
			$result  = $uc->insertUser($guid,$email,$password_hashed,$firstname,$lastname,$school,$gradyear,$question1,$answer1,$question2,$answer2);

			$val = $result['_return_value'];
			if( $val == 0)
				$success = true;

		}

	} 
}
else {
	$posted = false;
	
}

if($existing)	{
	$fmsg = "UserName is  already taken";
	$messageClass = "alert alert-danger";
}
else if($success ){
	$msg = "Account created successfully";
	$url = "index.php?msg=$msg";
	header("Location: ".$url);
}
?>



<html lang = "en">   
<head>
	<title>CT Nurse Training Register</title>

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
	.form-register {
		max-width: 530px;
		padding: 15px 35px 45px;
		margin: 0 auto;
		background-color: #fff;

		background: linear-gradient(rgba(0,0,0,.1), rgba(0,0,0,.1)), #fff;
		border: 1px solid rgba(0,0,0,0.1);  
		border-radius: 9px;

	}
	.form-register-heading {
		margin-bottom: 30px;
	}
	
</style>


<body>     
	<!-- Fixed Navbar Top -->
	<nav class="navbar navbar-dark  navbar-fixed-top py-2" style=" background-color: #3B80DB;">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="#" class="navbar-brand">CT Nurse Training Portal</a>
			</div>

			<a class="btn btn-success navbar-btn navbar-right " href="index.php">Login</a>
		</div>
	</nav>


	<div class="container-fluid">

		<div class="row  mt-4 py-3">

			<div class="col">

				<!-- Register form -->
				<form class="form-register" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return myFunction()"> 

					<?php if(isset($fmsg)){ ?><div class="<?php echo $messageClass; ?>"> <?php echo $fmsg; ?> </div><?php } ?>

					<div class="text-center mb-4">
						<h1 class="text-primary form-register-heading">Register here</h1>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-6">
							<label for="firstname" class="input-group text-primary">First Name:</label>
							<input type="text"  name="fname" class="form-control" id="firstname" placeholder="First Name" required autofocus>
						</div>

						<div class="form-group col-sm-6">
							<label for="lastname" class="input-group text-primary">Last Name:</label>
							<input type="text" name="lname" class="form-control" id="lastname" placeholder="Last Name" required >
						</div>
					</div>

					<div class="form-row">

						<div class="form-group col">
							<label for="username" class="input-group text-primary">Email:</label>
							<input type="text" name="email"  class="form-control" id="username" placeholder="Email" required >
						</div></div>
						<div class="form-row">    
							<div class="form-group col-sm-7">
								<label for="schoolname" class="input-group text-primary">School Name:</label>
			<!-- <select id="inputCollege" class="form-control" required>
				<option selected>Select..</option>
				<option>...</option>
				<option>other</option>
				
			</select> -->

			<input type="search" name="school"  class="input-group text-primary form-control" id="schoolname" autocomplete="off" required="required" placeholder="Enter school" list="listSchools">

			<datalist id="listSchools">



				<?php
	            //load schools from database
				$result = $uc->getSchools();

				foreach($result as $row){

					echo "<option value='" . $row['school_name'] . "'>" . $row['school_name'] . "</option>";
				}

				?>

			</datalist> 
		</div>

		<div class="form-group col-sm-5">
			<label for="inputGyear" class="input-group text-primary">Grad year</label>
			<select name="gyear" id="inputGyear" class="form-control" required>
				<option selected>Select</option>


				
			</select>
			<script type="text/javascript">
				var min = new Date().getFullYear(),
				max = min + 9,
				select = document.getElementById('inputGyear');

				for (var i = min; i<=max; i++){
					var opt = document.createElement('option');
					opt.value = i;
					opt.innerHTML = i;
					select.appendChild(opt);
				}
			</script>
		</div>

	</div>

	<div class="form-row">
		<div class="form-group col-sm-6">
			<label for="pass1" class="input-group text-primary">Create Password:</label>
			<input type="password" class="form-control" id="pass1" placeholder="password" required >
		</div>

		<div class="form-group col-sm-6">
			<label for="inputPassword" class="input-group text-primary">Confirm Password:</label>
			<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Confirm password" required >



		</div>
	</div>
	<div class="form-row">    
		<div class="form-group col-sm-12">
			<label for="securityQuestion1" class="input-group text-primary">Security Question 1:</label>
			<select name="ques1" id="securityQuestion1" class="form-control" required>
				<option value="" disabled selected>Select..</option>
				<?php
	            //load security questions from database
				$result = $uc->getSecurityQuestions();

				foreach($result as $row){

					echo "<option value='" . $row['secret_question'] . "'>" . $row['secret_question'] . "</option>";
				}

				?>
				
				
			</select>
			<input type="textbox" placeholder="Enter Answer" name="ans1" class="form-control my-2" id="securityQuestion1" required>
		</div>
		<div class="form-group col-sm-12">
			<label for="securityQuestion2" class="input-group text-primary">Security Question 2:</label>
			<select name="ques2" id="securityQuestion2" class="form-control" required>
				<option value="" disabled selected>Select..</option>
				<?php
	            //load security questions from database
				$result = $uc->getSecurityQuestions();

				foreach($result as $row){

					echo "<option value='" . $row['secret_question'] . "'>" . $row['secret_question'] . "</option>";
				}

				?>
				
				
			</select>
			<input type="textbox" placeholder="Enter Answer"  name="ans2" class="form-control my-2" id="securityQuestion2" required>
		</div>
	</div>

	<input type="submit" name="submit" value="Register" class="btn btn-success">

</form>
</div>

</div>

</div>

<script type="text/javascript">
	function myFunction() {
		var pass1 = document.getElementById("pass1").value;
		var inputPassword = document.getElementById("inputPassword").value;
		var ok = true;
		if (pass1 != inputPassword) {
        //alert("Passwords Do not match");
        document.getElementById("pass1").style.borderColor = "#E34234";
        document.getElementById("inputPassword").style.borderColor = "#E34234";
        ok = false;
    }
    
    return ok;
}


</script>
</body>
</html>
