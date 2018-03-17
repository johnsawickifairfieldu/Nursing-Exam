<html>
<head>
  <title>Nursing Training Module 1</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
  <form class="form" method="post" action="ExamHandler.php"> 
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
    <p>

     <?php  
     require_once("TrainingController.php");
     $tc = new TrainingController();
     if(!empty($_GET['training_id'])){
       $trainingModule_id = $_GET['training_id'];
     }
     ?>
     <h2> <?php echo " Training Module: $trainingModule_id"; ?></h2><br/>
     <?php
     $result  = $tc->getTrainingModuleLinks( $trainingModule_id );	
     
     foreach($result as $row){
      echo '<iframe width="640" height="360" src="'.$row['full_path_to_material'].'" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>'; 
    }

    ?>
    
  </p>
  <input type="hidden" name="training_id" value="<?php echo $trainingModule_id; ?>"/>
  <input type="submit" name="submit" value="Start Exam" >


</form>

</body>
</html>
