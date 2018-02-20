<?php
require_once('config.php');
require_once("UserController.php");
$uc = new UserController();


if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword'])){

    $email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword =  $_POST['confirmPassword'];
	
	if($password == $confirmPassword){
	$password_hashed = password_hash($password, PASSWORD_DEFAULT);
	$result  = $uc->resetPassword( $email , $password_hashed);	
	}else{
		$fmsg = "Password mismatch";
	}
	
	if($result == 1){
		header('Location: passwordResetSuccess.html');
	}else{
		$fmsg = "Reenter password details.";
	}

}


?>

<html>
  <head>
    <title>Reset Password</title>
	
  </head>
  <body >
 
     <div >
      <form role = "form"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
      <?php if(isset($fmsg)){ ?><div role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
        <h2>Reset Password</h2>
		<?php $email = $_GET['email']; ?>
		<input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" >
		 Enter New Password : <input type="password" name="password" required="required" >
  <br><br>
         Confirm Password : <input type="password" name="confirmPassword" required="required" >
  <br><br>
        <button type="submit" name = "submit">Save</button>
        
      </form>
</div>

  </body>
</html>