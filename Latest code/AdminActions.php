
<?php
session_start();
require_once("AdminController.php");
$ac = new AdminController();


?>

<html>
<head>
  <title>Nursing Exam</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
 
  <form class="form" method="post" action="AdminActions2.php"> 
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
     <?php
if(!empty($_GET['addQues'])){
       $addQues = $_GET['addQues'];
     }else if(!empty($_GET['deleteQues'])){
     	 $deleteQues = $_GET['deleteQues'];
     }

     if($addQues){
?>

<div >
  <p>
  <select name="training"  id="training" required  >
				<option value="" disabled selected>Select..</option>
				<?php
	            //load security questions from database
				$result = $ac->getTrainings();

				foreach($result as $row){

					echo "<option value='" . $row['training_description'] . "'>" . $row['training_description'] . "</option>";
				}

				?>
				
				
			</select>

  </p><br/>
</div>



<input type="hidden" name="addQuesAns" value="true">

<?php
}else if($deleteQues){
	
}
?>
<input type="submit" name="submit">
  
</form>

</body>
</html>
