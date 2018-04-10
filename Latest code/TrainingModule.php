

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Collapsible sidebar using Bootstrap 3</title>

         <!-- Bootstrap CSS CDN -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
 <link rel="stylesheet" href="style2.css">


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- Our Custom CSS -->
       
    </head>
    <body>
 

<nav class="navbar navbar-expand-lg fixed-top" id="topnav">
  <a href="#" class="navbar-brand">CT NURSE TRAINING</a>
   <div class="navbar-header mr-auto">
                            <button type="button" id="sidebarCollapse" class="btn btn-sm navbar-btn">
                               

            <span>Toggle Sidebar</span>  <i class="fa fa-navicon"></i>
                            </button>
                        </div>

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
            <!-- Sidebar Holder -->
            <nav id="sidebar">
               

                <ul class="list-unstyled components">
                  <li class="active">
                     <a href="#">   <!--  data-toggle="collapse" aria-expanded="false" -->
                            <i class="fa fa-pie-chart"></i>
                            Overview
                        </a>
                  </li>
                    <li >
                        <a href="#materialSubmenu" class="accordian-toggle collapse" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-file-pdf-o"></i>
                            Materials  <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="materialSubmenu">
                            <li><a href="TrainingMaterial.php?training_id=1">Material 1</a></li>
                            <li><a href="TrainingMaterial.php?training_id=2">Material 2</a></li>
                            <li><a href="TrainingMaterial.php?training_id=3">Material 3</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#testSubmenu"  data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-pencil"></i>
                            Tests <i class="fa fa-angle-down"></i>
                        </a>
                         <ul class="collapse list-unstyled" id="testSubmenu">
                            <li><a href="ExamHandler.php?training_id=1">Test 1</a></li>
                            <li><a href="ExamHandler.php?training_id=2">Test 2</a></li>
                            <li><a href="ExamHandler.php?training_id=3">Test 3</a></li>
                        </ul>
                        
                    </li>
               
                    <li>
                        <a href="#">
                            <i class="fa fa-paperclip"></i>
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-send"></i>
                            Contact
                        </a>
                    </li>
                </ul>

              
            </nav>

            <!-- Page Content Holder -->
            <div id="content">

<h3>Overview</h3>
<div class="card-deck ">
  <div class="card col-sm-3">
 
    <div class="progress card-img-top"  style="height:20px; margin-top: 5px;">
  <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
    <div class="card-body">
      <h5 class="card-title">Materials Completed</h5>
      <p class="card-text"></p>
      <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>

    </div>
  </div>
  <div class="card col-sm-3">
   
    <div class="progress card-img-top" style="height:20px; margin-top: 5px;">
  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
    <div class="card-body">
      <h5 class="card-title">Tests Completed</h5>
      <p class="card-text"></p>
      <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>

    </div>
  </div>
   <div class="card col-sm-3">
  
    <div class="progress card-img-top"  style="height:20px; margin-top: 5px;">
  <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
    <div class="card-body">
      <h5 class="card-title">Reports Sent</h5>
      <p class="card-text"></p>
      <div class="card-footer">
      <small class="text-muted">Last updated 3 mins ago</small>
    </div>

    </div>
  </div>
</div>
               
            </div>
        </div>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
         </script>
    </body>
</html>