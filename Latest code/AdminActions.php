
<?php

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
				
				$msg = "created training module succesfully";
				

				$url = "AdminPage.php?msg=$msg";
				header("Location: ".$url);
			}
		}
	}

}else{
	?>

	<html>
	<head>
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
						<div class="container text-center">

							
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

										<nav aria-label="breadcrumb" class="py-3">
											<ol class="breadcrumb">
												<li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
												
												<li class="breadcrumb-item active" aria-current="page">Choose Training</li>
											</ol>
										</nav>


										<div class="container mt-5" >
											<div class="row">
												<label class="col-md-4 col-form-label" for="training">Choose Training Module :</label>
												<select name="training" class="form-control col-md-8" id="training" required  >
													<option value="" disabled selected>Select..</option>
													<?php
													
													$result = $ac->getTrainings();

													foreach($result as $row){

														echo "<option value='" . $row['training_description'] . "'>" . $row['training_description'] . "</option>";
													}

													?>
													
													
												</select>
											</div>
											<br/>
										</div>

										<input type="hidden" name="addQuesAns" value="<?php echo $addQuesAns; ?>">


										<?php
									}
								} else if($deleteQues != null){
									if($deleteQues == 'Y'){
										?>
										<nav aria-label="breadcrumb" class="py-3">
											<ol class="breadcrumb">
												<li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
												
												<li class="breadcrumb-item active" aria-current="page">Choose Training</li>
											</ol>
										</nav>
										<div class="container mt-2">
											<div class="row">
												<label class="col-md-4 col-form-label" for="training">Choose Training Module :</label>
												<select name="training" class="form-control col-md-8" id="training" required  >
													<option value="" disabled selected>Select..</option>
													<?php
													
													$result = $ac->getTrainings();

													foreach($result as $row){

														echo "<option value='" . $row['training_description'] . "'>" . $row['training_description'] . "</option>";
													}

													?>
													
													
												</select>

											</div><br/>
										</div>

										<input type="hidden" name="deleteQues" value="<?php echo $deleteQues; ?>">

										<?php
									}
								}else if($editMaterial != null){
									if($editMaterial == 'Y'){
										?>
										<nav aria-label="breadcrumb" class="py-3">
											<ol class="breadcrumb">
												<li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
												
												<li class="breadcrumb-item active" aria-current="page">Choose Training</li>
											</ol>
										</nav>
										<div class="container mt-5" >
											<div class="row">
												<label class="col-md-4 col-form-label" for="training">Choose Training Module :</label>
												<select name="training" class="form-control col-md-8" id="training" required  >
													<option value="" disabled selected>Select..</option>
													<?php
													
													$result = $ac->getTrainings();

													foreach($result as $row){

														echo "<option value='" . $row['training_description'] . "'>" . $row['training_description'] . "</option>";
													}

													?>
													
													
												</select>

											</div><br/>
										</div>

										<input type="hidden" name="editMaterial" value="<?php echo $editMaterial; ?>">

										<?php
									}
								}else if($addMaterial != null){
									if($addMaterial == 'Y'){
										?>
										<nav aria-label="breadcrumb" class="py-3">
											<ol class="breadcrumb">
												<li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
												
												<li class="breadcrumb-item active" aria-current="page">Enter Details</li>
											</ol>
										</nav>
										<div class="container mt-5 ">
											<div class="row justify-content-center">
												<input type="text" class="col-md-4 form-control m-3" name="training_description" placeholder="Enter training module name" autofocus>
												<input type="text"  class="col-md-4 form-control m-3" name="url" placeholder="Enter the URL">
												<input type="hidden" name="addMaterial" value="<?php echo $addMaterial; ?>">
											</div></div>
											<?php
										}
									}
									?></br></br>
									<input type="submit"  class="btn btn-success" name="submit">
									
								</form>
							</div>
						</div>
					</div>

				</body>
				</html>

				<?php
			}
			?>
