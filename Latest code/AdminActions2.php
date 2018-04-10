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
			//echo "Added Question";
			$msg = "Added Question";
			$url = "AdminPage.php?msg=$msg";
			header("Location: ".$url);
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
				//echo "edited material succesfully";
				$msg = "edited material succesfully";
				$url = "AdminPage.php?msg=$msg";
				header("Location: ".$url);

			}
		}
	}

}else{

	?>

	<html>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">



	<title>Admin Portal</title>



	<!-- Bootstrap CSS CDN -->

	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



	<link rel="stylesheet" href="adminStyle.css">





	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<!-- Our Custom CSS -->



</head>

<body>





	<nav class="navbar navbar-expand-md fixed-top" id="topnav">

		<a href="#" class="navbar-brand">CT NURSE TRAINING</a>


		<button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">

			<span class="navbar-toggler-icon"></span>

		</button>

		<div class="collapse navbar-collapse" id="navbarNavDropdown">



			<ul class="nav navbar-nav navbar-right ml-auto">

				<li class="nav-item dropdown">


					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 

						<a class="nav-link dropdown-toggle mr-auto userbutton" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <span class="fa fa-user"></span>



							<?php

							session_start();

							if(isset($_SESSION['firstname']) && isset($_SESSION['lastname'])){

								$firstname = $_SESSION['firstname'];

								$lastname = $_SESSION['lastname'];

								echo " Welcome $firstname $lastname";

							}

							?>





						</a>

						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

							<a class="dropdown-item" href="#">Profile</a>

							<a class="dropdown-item" href="#">Settings</a>



						</div></form>

					</li>

					<li class="nav-item"><a href="logout.php" class="nav-link userbutton">

						<span class="fa fa-mail-forward"></span> Logout</a></li>

					</ul>





				</div>



			</nav>

			<div class="wrapper">
				<div id="content">
					<div class="text-center">
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


									<nav aria-label="breadcrumb" class="py-3">
										<ol class="breadcrumb">
											<li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
											<li class="breadcrumb-item" aria-current="page"><a href="AdminActions.php?addQuesAns=Y">Add Q&A</a></li>
											<li class="breadcrumb-item active" aria-current="page">Enter Details</li>
										</ol>
									</nav>



									<div class="row">
										<label class="col-sm-4 col-form-label" for="exam">Select Exam :</label>
										<select name="exam" class="form-control col-sm-6" id="exam" required  >

											<option value="" disabled selected>Select..</option>
											<?php

											$result = $ac->getExams($training_id);

											foreach($result as $row){

												echo "<option value='" . $row['exam_description'] . "'>" . $row['exam_description'] . "</option>";
											}

											?>


										</select></div><br/>
										<p>Note: Enter Y for corrcet answer and N for wrong answer</p>
										<div class="row mb-3">

											<input type="hidden" class="form-control" name="addQuesAns" value="<?php echo $addQuesAns; ?>">
											<label name="question" class="col-sm-2 col-form-label " for="question">Question :</label>

											<input type="text" class="form-control col-sm-10" name="question" id="Question" placeholder="Enter the Question" required>

										</div>

										<div class="row my-2">

											<label name="option1" class="col-sm-3 col-form-label" for="option1">Option 1 :</label>

											<input type="text" class="form-control col-sm-4" id="option1" name="option1" id="option1" placeholder="Option 1" required>


											<input type="text" class="form-control col-sm-4" name="isCorrect1" placeholder="Enter Y/N" required>
											<br/>
										</div>


										<div class="row my-2">
											<label name="option2" class="col-form-label col-sm-3">Option 2 :</label>
											<input type="text" class="form-control col-md-4" name="option2" placeholder="Option 2" required>
											<input type="text" class="form-control col-md-4" name="isCorrect2" placeholder="Enter Y/N" required>
											<br/></div>

											<div class="row my-2">
												<label name="option3" class="col-form-label col-sm-3">Option 3 :</label>
												<input type="text" class="form-control col-md-4" name="option3" placeholder="Option 3" required>
												<input type="text" class="form-control col-md-4" name="isCorrect3" placeholder="Enter Y/N" required>
												<br/></div>

												<div class="row my-2">
													<label name="option4" class="col-form-label col-sm-3">Option 4 :</label>
													<input type="text" class="form-control col-md-4" name="option4" placeholder="Option 4" required>
													<input type="text" class="form-control col-md-4" name="isCorrect4" placeholder="Enter Y/N" required>
													<br/></div>
												</div>

												

											<?php
										}
									}else if($deleteQues != null){

										if($deleteQues == 'Y'){

											?>

											<nav aria-label="breadcrumb" class="py-3">
												<ol class="breadcrumb">
													<li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
													<li class="breadcrumb-item" aria-current="page"><a href="AdminActions.php?deleteQues=Y"> Delete Q&A </a></li>
													<li class="breadcrumb-item active" aria-current="page">Select Exam</li>
												</ol>
											</nav>



											<div class="row">
												<label for="exam" class="col-sm-2 col-form-label">Select Exam:</label>
												<select name="exam" class="form-control col-sm-8" id="exam" required>


													<option value="" disabled selected>Select..</option>
													<?php

													$result = $ac->getExams($training_id);

													foreach($result as $row){

														echo "<option value='" . $row['exam_description'] . "'>" . $row['exam_description'] . "</option>";
													}

													?>


												</select></div></div>
												<input type="hidden" name="deleteQues" value="<?php echo $deleteQues; ?>">


												<?php
											}
										}else if($editMaterial != null){
											if($editMaterial == 'Y'){
												?>

												<nav aria-label="breadcrumb" class="py-3">
													<ol class="breadcrumb">
														<li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
														<li class="breadcrumb-item" aria-current="page"><a href="AdminActions.php?editMaterial=Y"> Edit Material </a></li>
														<li class="breadcrumb-item active" aria-current="page">Enter New Url</li>
													</ol>
												</nav>



												<div class="row justify-content-center">
													<input type="text" class="form-control col-sm-4" name="editUrl"  placeholder="Enter new URL">
													<input type="hidden" class="form-control" name="editMaterial" value="<?php echo $editMaterial; ?>">
												</div>
											</div>
											<?php
										}
									}


									if($training_id != null){
										?>
										<input type="hidden" name="training_id"  value="<?php echo $training_id; ?>">
										<?php
									}
									?>
								</br></br>
								<div class="container text-center">

									<input type="submit" class="btn btn-success" name="submitActions">

								</div>
							</form>
						</div>
					</div></div>
				</body>
				</html>
				<?php
			}
			?>