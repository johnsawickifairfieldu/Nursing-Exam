
<?php
session_start();
require_once("AdminController.php");
$ac = new AdminController();

if (isset($_POST['submitActions']) ){

	if(isset($_POST['exam'])){
		$exam_description = $_POST['exam'];
		$result = $ac->getExamId($exam_description);
		foreach($result as $row){
			$exam_id = $row['exam_id'];
		}
	}

	if(isset($_POST['addQuesAns']) && isset($_POST['question']) && isset($_POST['option1']) && isset($_POST['option2']) && isset($_POST['option3']) && isset($_POST['option4']) && isset($_POST['isCorrect1']) && isset($_POST['isCorrect2']) && isset($_POST['isCorrect3']) && isset($_POST['isCorrect4'])){
		$addQuesAns = $_POST['addQuesAns'];
		$question_text = $_POST['question'];
		$option1_text = $_POST['option1'];
		$option2_text = $_POST['option2'];
		$option3_text = $_POST['option3'];
		$option4_text = $_POST['option4'];
		$isCorrect1 = $_POST['isCorrect1'];
		$isCorrect2 = $_POST['isCorrect2'];
		$isCorrect3 = $_POST['isCorrect3'];
		$isCorrect4 = $_POST['isCorrect4'];

		if($addQuesAns != null){

			if($isCorrect1 == 'Y'){
				$isCorrect1 = 1;
				$isCorrect2 = 0;
				$isCorrect3 = 0;
				$isCorrect4 = 0;
			}else if($isCorrect2 == 'Y'){
				$isCorrect1 = 0;
				$isCorrect2 = 1;
				$isCorrect3 = 0;
				$isCorrect4 = 0;
			}else if($isCorrect3 == 'Y'){
				$isCorrect1 = 0;
				$isCorrect2 = 0;
				$isCorrect3 = 1;
				$isCorrect4 = 0;
			}else if($isCorrect4 == 'Y'){
				$isCorrect1 = 0;
				$isCorrect2 = 0;
				$isCorrect3 = 0;
				$isCorrect4 = 1;
			}


			$result = $ac->addQuesAns($exam_id,$question_text,$option1_text,$isCorrect1,$option2_text,$isCorrect2,$option3_text,$isCorrect3,$option4_text,$isCorrect4);
			echo "Added Question";
		}
	}else if(isset($_POST['deleteQues'])){
		$deleteQues = $_POST['deleteQues'];

		if($deleteQues != null){
			$url = "AdminActions3.php?exam_id=$exam_id";
			header("Location: ".$url);
		}
	}else if(isset($_POST['editMaterial']) && isset($_POST['editUrl']) && isset($_POST['training_id'])){
		$editMaterial = $_POST['editMaterial'];
		$editUrl = $_POST['editUrl'];
		$training_id =$_POST['training_id'];

		if($editMaterial != null){
			$result = $ac->updateTrainingURL($training_id ,$editUrl);
			if($result >0){
				echo "edited material succesfully";
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


	</head>
	<body>

		<form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
			<?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
			<?php
			$addQuesAns = null;
			$deleteQues = null;
			$editMaterial =null;
			$training = null;
			$training_id = null;



			if(isset($_GET['addQuesAns'])){
				$addQuesAns = $_GET['addQuesAns'];
			}
			else if(isset($_GET['deleteQues'])){
				$deleteQues = $_GET['deleteQues'];
			}
			else if(isset($_GET['editMaterial'])){
				$editMaterial = $_GET['editMaterial'];
			}

			if(isset($_SESSION['training'])){
				$training = $_SESSION['training'];
			}

			$result = $ac->getTrainingId($training);
			foreach($result as $row){
				$training_id = $row['training_id'];
			}

			if($addQuesAns != null){
				if($addQuesAns == 'Y'){
					?>
					<p>Select Exam</p>
					<select name="exam"  id="exam" required>
						<option value="" disabled selected>Select..</option>
						<?php
						
						$result = $ac->getExams($training_id);

						foreach($result as $row){

							echo "<option value='" . $row['exam_description'] . "'>" . $row['exam_description'] . "</option>";
						}

						?>


					</select><br/><br/>
					<p>Note: Enter Y for corrcet answer and N for wrong answer</p>
					<input type="hidden" name="addQuesAns" value="<?php echo $addQuesAns; ?>">
					<label name="question">Question :</label>
					<input type="text" name="question" placeholder="Enter the Question" required><br/><br/>

					<label name="option1">Option 1 :</label>
					<input type="text" name="option1" placeholder="Option 1" required>
					<input type="text" name="isCorrect1" placeholder="Enter Y/N" required>
					<br/>

					<label name="option2">Option 2 :</label>
					<input type="text" name="option2" placeholder="Option 2" required>
					<input type="text" name="isCorrect2" placeholder="Enter Y/N" required>
					<br/>

					<label name="option3">Option 3 :</label>
					<input type="text" name="option3" placeholder="Option 3" required>
					<input type="text" name="isCorrect3" placeholder="Enter Y/N" required>
					<br/>

					<label name="option4">Option 4 :</label>
					<input type="text" name="option4" placeholder="Option 4" required>
					<input type="text" name="isCorrect4" placeholder="Enter Y/N" required>
					<br/>

					<?php
				}
			}else if($deleteQues != null){

				if($deleteQues == 'Y'){

					?>
					<p>Select Exam</p>
					<select name="exam"  id="exam" required>


						<option value="" disabled selected>Select..</option>
						<?php
						
						$result = $ac->getExams($training_id);

						foreach($result as $row){

							echo "<option value='" . $row['exam_description'] . "'>" . $row['exam_description'] . "</option>";
						}

						?>


					</select><br/><br/>
					<input type="hidden" name="deleteQues" value="<?php echo $deleteQues; ?>">


					<?php
				}
			}else if($editMaterial != null){
				if($editMaterial == 'Y'){
					?>
					<input type="text" name="editUrl"  placeholder="Enter new URL">
					<input type="hidden" name="editMaterial" value="<?php echo $editMaterial; ?>">
					<?php
				}
			}
			

			if($training_id != null){
				?>
				<input type="hidden" name="training_id"  value="<?php echo $training_id; ?>">
				<?php
			}
			?>
			<input type="submit" name="submitActions">

			
		</form>

	</body>
	</html>
	<?php
}
?>