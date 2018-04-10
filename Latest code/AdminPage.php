
<?php
session_start();
require_once("AdminController.php");
$ac = new AdminController();

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

        <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 

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




		





		<!-- <a href="resultsHandler.php">Check Results </a><br/>
		<a href="AdminActions.php?addQuesAns=Y">Add Questions and Answers</a><br/>
		<a href="AdminActions.php?deleteQues=Y">Delete Questions and Answers</a><br/>
		<a href="AdminActions.php?addMaterial=Y">Add Training Materials</a><br/>
		<a href="AdminActions.php?editMaterial=Y">Edit Training Materials</a><br/>
		<a href="logout.php">Logout</a> -->


<div class="wrapper">

	<div id="content">
  <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  	<br/>
  	<?php
						if(!empty($_GET['msg'])){
							$fmsg = $_GET['msg'];
							$messageClass = "alert alert-success"; 
						}
						?>

		<?php if(isset($fmsg)){ ?><div class="<?php echo $messageClass; ?>"> <?php echo $fmsg; ?> </div><?php } ?>
  <!-- ACTIONS -->
  <section id="action" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
         <div class="col-md-4  ">
        
          <a href="resultsAdHocReport.php" class="col btn btn-warning btn-block" id="btn1" ><i class="fa fa-search"></i> Check Results
          </a>
        </div>
        <div class="col-md-4">
          <a href="AdminActions.php?addMaterial=Y" class="col btn btn-primary btn-block" id="btn2"><i class="fa fa-plus"></i> Add Training Module
          </a>
        </div>
        <div class="col-md-4 ">
          <a href="AdminActions.php?editMaterial=Y" class="col btn btn-info btn-block" id="btn3">
            <i class="fa fa-times"></i> Edit Training Module 
          </a>
        </div>
      </div>
      
      <div class="row pt-md-3">
        <div class="col-md-4 ">
          <a href="AdminActions.php?addQuesAns=Y" class="btn btn-success btn-block" id="btn4">
            <i class="fa fa-plus"></i> Add Q&A
          </a>
        </div>
        <div class="col-md-4 ">
          <a href="AdminActions.php?deleteQues=Y" class="btn btn-danger btn-block" id="btn5">
            <i class="fa fa-times"></i> Delete Q&A
          </a>
        </div>
      </div>
    </div>
  
  </section>
</form>

</div>

</div>
</body>
</html>
