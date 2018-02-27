<?php
//ob_start();
session_start();
//require_once('config.php');
require_once("UserController.php");
$uc = new UserController();
$existing = false;
$posted = true;

if (isset($_POST['submit']) && !empty($_POST['answer1']) && !empty($_POST['answer2'])){

    $email = $_POST['email'];
    $question1 = $_POST['question1'];
	$answer1 = $_POST['answer1'];
	$question2 = $_POST['question2'];
	$answer2 =  $_POST['answer2'];

	//check if user exists
	$result1  = $uc->ifUserExists( $email );			

	if($result1){
		$existing = true;
	}
	if($existing){
	$result  = $uc->securityQuestionsValidate( $email , $question1 , $answer1 , $question2 , $answer2);	
	if(!$result){
	$fmsg = "Invalid Questions and Answers";
	$messageClass = "alert alert-danger";
	}else{
        $_SESSION['email'] = $email;
		//$url = "resetPassword.php?email=$email";
       // header("Location: ".$url);
         header('Location: resetPassword.php');
	}
}else{
	$fmsg = "Invalid email";
	$messageClass = "alert alert-danger";
}

}
else{
	$posted = false;
	
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
			<nav class="navbar navbar-dark bg-danger navbar-fixed-top py-2">
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

				
<form class="form-register"  role="form" role = "form"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">

      <?php if(isset($fmsg)){ ?><div class="<?php echo $messageClass; ?>"> <?php echo $fmsg; ?> </div><?php } ?>

      

	<div class="text-center mb-4">
		<h1 class="text-primary form-register-heading">Forgot password</h1>
	</div>
	
    <div class="form-row">
    	
    	<div class="form-group col">
    		<label for="username" class="input-group text-primary">Enter you Email:</label>
			<input type="text" name="email" class="form-control" id="username" placeholder="Email" required >
    	</div></div>
     
   
	 <div class="form-row">    
        <div class="form-group col-sm-12">
    		<label for="securityQuestion1" class="input-group text-primary">Security Question 1:</label>
			<select id="securityQuestion1" name="question1" class="form-control" required>
				<option value="" disabled selected>Select..</option>
				<?php
	//load security questions from database
				$result = $uc->getSecurityQuestions();

				foreach($result as $row){

					echo "<option value='" . $row['secret_question'] . "'>" . $row['secret_question'] . "</option>";
				}

				?>
				
				
			</select>
			<input type="textbox" name="answer1" placeholder="Enter answer"  class="form-control my-2" id="securityQuestion1" required>
    	</div>
    	 <div class="form-group col-sm-12">
    		<label for="securityQuestion2" class="input-group text-primary">Security Question 2:</label>
			<select id="securityQuestion2" name="question2" class="form-control" required>
				<option value="" disabled selected>Select..</option>
				<?php
	//load security questions from database
				$result = $uc->getSecurityQuestions();

				foreach($result as $row){

					echo "<option value='" . $row['secret_question'] . "'>" . $row['secret_question'] . "</option>";
				}

				?>
				
				
			</select>
			<input type="textbox" name="answer2" placeholder="Enter answer"  class="form-control my-2" id="securityQuestion2" required>
    	</div>
</div>

	<input type="submit" name="submit" value="Reset Password" class="btn btn-success">

</form>
				</div>

		</div>
	
	</div>
	
	</body>
</html>