
<?php

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

require('config.php');
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
else {
		$posted = false;
	}

if($existing)	{
	$msg = "UserName is  already taken";
}
else if($success ){
	header('Location: success.html');
	}
?>

<html>
<head>
<title>Nursing Register</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<h2> Nursing Registartion Form </h2>
<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
  E-mail: <input type="text" name="email" required="required" >
  <br><br>
   Password: <input type="password" name="password" required="required" >
  <br><br>
  First Name: <input type="text" name="fname" required="required" >
  <br><br>
  Last Name: <input type="text" name="lname" required="required" >
  <br><br>
  School Name: <select name="school">
  
  <?php
	//load schools from database
$result = $uc->getSchools();

				foreach($result as $row){
				
					echo "<option value='" . $row['school_name'] . "'>" . $row['school_name'] . "</option>";
				}

  ?>
  
</select>
  <br><br>
  Graduation Year:<input type="text" name="gyear"  >
   <br><br>
   
   <label for="ques1">What is your pet's name?</label>
  <input type="hidden" name="ques1" id="ques1" value="What is your pet's name?" >
   
 <input type="text" name="ans1" placeholder="Enter your answer" required="required" >
   <br><br>
   
   <label for="ques2">What was your first school's name?</label>
  <input type="hidden" name="ques2" id="ques2" value="What was your first school's name?" >
   
  <input type="text" name="ans2" placeholder="Enter your answer" required="required" >
   <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</body>
</html>
