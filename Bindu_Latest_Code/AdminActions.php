
<?php
session_start();
require_once("AdminController.php");
$ac = new AdminController();

if(isset($_POST['submit'])){

	if(isset($_POST['training'])){
		$training = $_POST['training'];
		$_SESSION['training'] = $training;
	}

	if(isset($_POST['addQuesAns']))	{

		$addQuesAns = $_POST['addQuesAns'];
		$url = "AdminActions2.php?addQuesAns=$addQuesAns";
		header("Location: ".$url);

	}else if(isset($_POST['deleteQues']))	{

		$deleteQues = $_POST['deleteQues'];
		$url = "AdminActions2.php?deleteQues=$deleteQues";
		header("Location: ".$url);

	}else if(isset($_POST['editMaterial']))	{

		$editMaterial = $_POST['editMaterial'];
		$url = "AdminActions2.php?editMaterial=$editMaterial";
		header("Location: ".$url);
		
	}else if(isset($_POST['addMaterial']) && isset($_POST['training_description']) && isset($_POST['url'])){
		$addMaterial = $_POST['addMaterial'];
		$training_description = $_POST['training_description'];
		$url = $_POST['url'];

		if($addMaterial != null){
			$result = $ac->addTrainingMaterial($training_description,$url);
			if($result >0){
				echo "created training module succesfully";
			}
		}
	}

}else{
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
		
		<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
			<?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
			<?php
			$addQuesAns = null;
			$deleteQues = null;
			$addMaterial = null;
			$editMaterial = null;
			if(!empty($_GET['addQuesAns'])){
				$addQuesAns = $_GET['addQuesAns'];
			}else if(!empty($_GET['deleteQues'])){
				$deleteQues = $_GET['deleteQues'];
			}else if(!empty($_GET['addMaterial'])){
				$addMaterial = $_GET['addMaterial'];
			}else if(!empty($_GET['editMaterial'])){
				$editMaterial = $_GET['editMaterial'];
			}

			if($addQuesAns != null){
				if($addQuesAns == 'Y'){
					?>

					<div >
						<p>
							<p>Choose Training Module</p>
							<select name="training"  id="training" required  >
								<option value="" disabled selected>Select..</option>
								<?php
								
								$result = $ac->getTrainings();

								foreach($result as $row){

									echo "<option value='" . $row['training_description'] . "'>" . $row['training_description'] . "</option>";
								}

								?>
								
								
							</select>

						</p><br/>
					</div>

					<input type="hidden" name="addQuesAns" value="<?php echo $addQuesAns; ?>">


					<?php
				}
			} else if($deleteQues != null){
				if($deleteQues == 'Y'){
					?>

					<div >
						<p>
							<p>Choose Training Module</p>
							<select name="training"  id="training" required  >
								<option value="" disabled selected>Select..</option>
								<?php
								
								$result = $ac->getTrainings();

								foreach($result as $row){

									echo "<option value='" . $row['training_description'] . "'>" . $row['training_description'] . "</option>";
								}

								?>
								
								
							</select>

						</p><br/>
					</div>

					<input type="hidden" name="deleteQues" value="<?php echo $deleteQues; ?>">

					<?php
				}
			}else if($editMaterial != null){
				if($editMaterial == 'Y'){
					?>

					<div >
						<p>
							<p>Choose Training Module</p>
							<select name="training"  id="training" required  >
								<option value="" disabled selected>Select..</option>
								<?php
								
								$result = $ac->getTrainings();

								foreach($result as $row){

									echo "<option value='" . $row['training_description'] . "'>" . $row['training_description'] . "</option>";
								}

								?>
								
								
							</select>

						</p><br/>
					</div>

					<input type="hidden" name="editMaterial" value="<?php echo $editMaterial; ?>">

					<?php
				}
			}else if($addMaterial != null){
				if($addMaterial == 'Y'){
					?>
					<input type="text" name="training_description" placeholder="Enter training module name">
					<input type="text" name="url" placeholder="Enter the URL">
					<input type="hidden" name="addMaterial" value="<?php echo $addMaterial; ?>">
					<?php
				}
			}
			?>
			<input type="submit" name="submit">
			
		</form>

	</body>
	</html>

	<?php
}
?>
