

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
                  <li >
                     <a href="#">   <!--  data-toggle="collapse" aria-expanded="false" -->
                            <i class="fa fa-pie-chart"></i>
                            Overview
                        </a>
                  </li>
                    <li class="active" >
                        <a href="#materialSubmenu" class="accordian-toggle collapse" data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-file-pdf-o"></i>
                            Materials  <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="materialSubmenu">
                            <?php
                            require_once("TrainingController.php");
                            $tc = new TrainingController();
                            $training_ids = $tc->getTrainingModuleIds();
                            for($index = 0;$index<count($training_ids);$index++){
                              $mat_id = $training_ids[$index]["training_id"];
                              $training_desc = $tc->getTrainingModuleDesc($mat_id);
                              echo '<li><a href="TrainingMaterial.php?training_id='.$mat_id.'">Material '.$training_desc[0]["training_description"].'</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <a href="#testSubmenu"  data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-pencil"></i>
                            Tests <i class="fa fa-angle-down"></i>
                        </a>
                         <ul class="collapse list-unstyled" id="testSubmenu">
                            <?php
                            $exam_ids = $tc->getExamIds();
                            for($index = 0;$index<count($exam_ids);$index++){
                              $mat_id = $exam_ids[$index]["exam_id"];
                              $exam_desc = $tc->getExamDesc($mat_id);
                              echo '<li><a href="ExamHandler.php?training_id='.$mat_id.'">Test '.$exam_desc[0]["exam_description"].'</a></li>';
                            }
                            ?>
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
 <form class="form" method="post" action="ExamHandler.php"> 
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
    <p>

     <?php  
     if(!empty($_GET['training_id'])){
       $trainingModule_id = $_GET['training_id'];
     }
     ?>
     <h2> 
      <?php        
      $training_desc = $tc->getTrainingModuleDesc($trainingModule_id);
      echo $training_desc[0]["training_description"]; 
      ?>  
      </h2><br/>
     <?php
     $result  = $tc->getTrainingModuleLinks( $trainingModule_id );  
     
     foreach($result as $row){
      echo '<iframe width="600" height="400" src="'.$row['full_path_to_material'].'" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>'; 
    }

    ?>
    
  </p>
  <input type="hidden" name="training_id" value="<?php echo $trainingModule_id; ?>"/>
  <input type="submit" class="btn btn-success form-control" name="submit" value="Start Exam" >


</form>
               
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
