
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
<div class="wrapper">
  <div id="content">
    
 

  <form class="form" method="post" action="resultsHandler.php"> 
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
    <?php

        require_once("AdminController.php");
    $ac = new AdminController();


    if(isset($_GET['search'])){
      $search = $_GET['search'];
    }

    if($search != null){
      if($search == 'school'){
        ?>
        <div class="container mt-5">
          <nav aria-label="breadcrumb" class="py-3">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
                   <li class="breadcrumb-item" aria-current="page"><a href="resultsAdHocReport.php" > Check Results</a></li>
                    
                    <li class="breadcrumb-item active" aria-current="page">School</li>
               </ol>
            </nav>

          <div class="row justify-content-center">
        <input type="search" name="school" class="form-control col-sm-8" autocomplete="off" required="required" placeholder="Select school" list="listSchools">
        <input type="hidden" name="search" value="school">
        <datalist id="listSchools">



          <?php
              //load schools from database
          $result = $ac->getSchools();

          foreach($result as $row){

            echo "<option value='" . $row['school_name'] . "'>" . $row['school_name'] . "</option>";
          }

          ?>

        </datalist> </div></div>
        <?php
      } else if($search == 'firstname'){
        ?>

 <div class="container mt-5">
          <nav aria-label="breadcrumb" class="py-3">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
                   <li class="breadcrumb-item" aria-current="page"><a href="resultsAdHocReport.php" > Check Results</a></li>
                    
                    <li class="breadcrumb-item active" aria-current="page">First Name</li>
               </ol>
            </nav>

          <div class="row justify-content-center">
        <input type="text" class="form-control col-sm-6" name="firstname" placeholder="Enter First Name">
        <input type="hidden" name="search" value="firstname">
      </div></div>
        <?php

      }else if($search == 'lastname'){

        ?>
         <div class="container mt-5">
          <nav aria-label="breadcrumb" class="py-3">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
                   <li class="breadcrumb-item" aria-current="page"><a href="resultsAdHocReport.php" > Check Results</a></li>
                    
                    <li class="breadcrumb-item active" aria-current="page">Last Name</li>
               </ol>
            </nav>

          <div class="row justify-content-center">
        <input type="text" name="lastname" class="form-control col-sm-6" placeholder="Enter Last Name">
        <input type="hidden" name="search" value="lastname">
      </div></div>
        <?php

      }

      ?>
    </br></br>
<div class="container text-center">
      <input type="submit" name="submit" class="btn btn-success">
    </div>
      <?php
    }
    ?>
  </form>
 </div>
</div> 
</body>
</html>
