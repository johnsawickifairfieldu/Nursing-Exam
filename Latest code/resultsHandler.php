

<html>
<head>
  <title>Nursing Exam</title>






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

        <style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;

}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>

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


  <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
    <?php 

   
    require_once("AdminController.php");
    $ac = new AdminController();

    $results = null;
    $training_id = null;
    $exam_id = null;
    $status = null;
    $search = null;
    $school = null;
    $firstname = null;
    $lastname = null;

    if(isset($_GET['results'])){
      $results = $_GET['results'];
    }

    else if(isset($_GET['training_id'])){
      $training_id = $_GET['training_id'];
    }

    else if(isset($_GET['exam_id'])){
      $exam_id = $_GET['exam_id'];
    }

    else if(isset($_GET['status'])){
      $status = $_GET['status'];
    }

    else if(isset($_POST['search'])){
      $search = $_POST['search'];
    }

    if(isset($_POST['school'])){
      $school = $_POST['school'];
    }else if(isset($_POST['firstname'])){
      $firstname = $_POST['firstname'];
    }else if(isset($_POST['lastname'])){
      $lastname = $_POST['lastname'];
    }


    if($results != null){

      $result = $ac->getResultSummery(null,null,null,null,null);

      resultsDisplay($result);

    } else if($training_id != null){

      if($training_id == 1 || $training_id == 2 || $training_id == 3 ){

        $trainingResult = $ac->getTrainingsDescription($training_id);
        foreach ($trainingResult as $val) {
         $result = $ac->getResultSummery($val['training_description'],null,null,null,null); 

         resultsDisplay($result);
       }
     }
   }else if($exam_id != null){

    if($exam_id == 1 || $exam_id == 2 || $exam_id == 3 ){

      $examResult = $ac->getExamDescription($exam_id);
      foreach ($examResult as $val) {
       $result = $ac->getResultSummery(null,$val['exam_description'],null,null,null); 

       resultsDisplay($result);
     }
   }
 } else if($status != null){

  if($status == 'passed' || $status == 'failed' ){

   $result = $ac->getResultSummery(null,null,$status,null,null); 
   resultsDisplay($result);
   
 }
} else if($search != null){

  if($search == 'school' || $search == 'firstname' || $search == 'lastname' ){
    if($school != null){
      $result = $ac->getResultSummery(null,null,null,$search,$school); 
    }else if($firstname != null){
      $result = $ac->getResultSummery(null,null,null,$search,$firstname); 
    }else if($lastname != null){
      $result = $ac->getResultSummery(null,null,null,$search,$lastname); 
    }

    resultsDisplay($result);

  }
}

function resultsDisplay($result){
  ?>
   <nav aria-label="breadcrumb" class="py-3">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
                   <li class="breadcrumb-item" aria-current="page"><a href="resultsAdHocReport.php" > Check Results</a></li>
                    
                    <li class="breadcrumb-item active" aria-current="page">Filtered Results</li>
               </ol>
            </nav>
  <div id="customers" class="mt-1">

  <?php
  echo "<table border='1' cellpadding='10'>";
  echo "<tr><th>Training</th><th>Exam</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Grade</th><th>Result Status</th><th>Graduation Year</th>
  <th>School Name</th><th>Exam End Date</th></tr>";
  foreach($result as $row){
    $gradeMark = $row['grade'];
    if($gradeMark == 1){
      $grade = 'A+';
      $status = 'Pass';
    }
    else if($gradeMark >= 0.70 && $gradeMark <= 0.80){
      $grade = 'A';
      $status = 'Pass';
    }else if($gradeMark >= 0.50 && $gradeMark <= 0.60){
      $grade = 'B';
      $status = 'Pass';
    }else if($gradeMark >= 0.30 && $gradeMark <= 0.40){
      $grade = 'B-';
      $status = 'Pass';
    }else if($gradeMark < 0.30){
      $grade = 'C';
      $status = 'Fail';
    }
    

    echo "<tr>";
    echo "<td>".$row['training_description']."</td>";
    echo "<td>".$row['exam_description']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td>".$row['first_name']. "</td>";
    echo "<td>".$row['last_name']."</td>";
    echo "<td>".$grade."</td>";
    echo "<td>".$status."</td>";
    echo "<td>".$row['graduation_year']."</td>";
    echo "<td>".$row['school_name']."</td>";
    echo "<td>".$row['ended']."</td>";
    echo "</tr>";
  }
  echo "</table>";

  ?>
</div>
  <?php
}


?>

</form>
</div>
</div>
</body>
</html>
