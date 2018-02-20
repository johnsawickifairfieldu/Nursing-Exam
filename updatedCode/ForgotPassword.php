<?php
require_once('config.php');
require_once("UserController.php");
$uc = new UserController();

if (isset($_POST['submit']) && !empty($_POST['ans1']) && !empty($_POST['ans2'])){

    $email = $_POST['email'];
	$answer1 = $_POST['ans1'];
	$answer2 =  $_POST['ans2'];
	
	$result  = $uc->securityQuestionsValidate( $email , $answer1 , $answer2);	
	if(!$result){
	$fmsg = "Invalid Answers.";
	}else{

		$url = "resetPassword.php?email=$email";
        header("Location: ".$url);
	}

}
?>

<html>
  <head>
    <title>Nurse Exam Forgot Password</title>
	
  </head>
  <body >
 
     <div >
      <form role = "form"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
      <?php if(isset($fmsg)){ ?><div role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
        <h2>Answer below security questions</h2>
		 E-mail: <input type="text" name="email" required="required" >
  <br><br>
        <div >
		<p>What is your pet's name?</p>
	  <input type="ans1" name="ans1" id="ans1" placeholder="Enter answer" required="required" autofocus>
	</div>
        <p>What was your first school's name?</p>
	  <input type="ans2" name="ans2" id="ans2" placeholder="Enter answer" required="required" autofocus>
	</div>
        <button type="submit" name = "submit">Reset Password</button>
        
      </form>
</div>

  </body>
</html>