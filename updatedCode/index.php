<?php  

ob_start();
session_start();

require_once('config.php');
require_once("UserController.php");
$uc = new UserController();

if (isset($_POST['login']) && isset($_POST) && !empty($_POST)){

	$email = $_POST['email'];
	$password =  $_POST['password'];
	
	$result  = $uc->validateLogin( $email , $password);	
	if(!$result){
	$fmsg = "Invalid Login Credentials.";
	}

}

if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])){

	echo "Welcome: " . $_SESSION['firstname'] ." ".$_SESSION['lastname']. "<br>";
	echo "You are logged into a session.<br>";
	echo "<a href='logout.php'>Logout</a>"; 
}else{

?>

<html>
  <head>
    <title>Nurse Exam Login</title>
	
  </head>
  <body >
 
     <div >
      <form role = "form"  action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
      <?php if(isset($fmsg)){ ?><div role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
        <h2>Please Login</h2>
        <div >
		<label  for="email" >Email</label>
	  <input type="email" name="email" id="email" placeholder="Enter email address" required="required" autofocus>
	</div>
	<br>
        <label for="inputPassword" >Password</label>
        <input type="password" name="password" id="inputPassword" placeholder="Enter password" required="required">
		<br>
        <button type="submit" name = "login">Login</button>
		<br>
        <a href="register.php">Register</a><br>
		<a href="ForgotPassword.php">Forgot Password?</a>
      </form>
</div>

  </body>
</html>

<?php } ?>