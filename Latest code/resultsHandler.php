<?php

require_once("AdminController.php");
include('style.css'); 
require_once("UserController.php");


$ac = new AdminController();


$filter = null;
$selectedTraining = null;
$selectedSchool = null;
$nameFilter = false;
$sort = null;
if(!isset($_POST['submit']) ){
$result = $ac->getResultSummery(null,null,null,null,null,null,$sort);
}

if(isset($_POST['submit']) ){
 $result = null;
 $schoolResult = null;
 $select = "Select";
 
 $filter = $_POST['filter'];
 $sort = $_POST['sort'];


 if($filter != null && $sort!= null){

  if($filter == "All"){
	  unset($_POST['trainingSelect']);
    unset($_POST['nameSearch']);
	unset($_POST['schoolSelect']);

    $result = $ac->getResultSummery(null,null,null,null,null,null,$sort);

}
  else if($filter == "School"){
    unset($_POST['trainingSelect']);
    unset($_POST['nameSearch']);
    

    $schoolResult = $ac->getSchools();

  }else if($filter == "Training"){
    unset($_POST['schoolSelect']);
    unset($_POST['nameSearch']);

    $trainingResult = $ac->getTrainings();

  }
  else if($filter == "Passed" || $filter == "Failed"){
    $status = $filter;
	unset($_POST['trainingSelect']);
    unset($_POST['nameSearch']);
	unset($_POST['schoolSelect']);
    $result = $ac->getResultSummery(null,null,$status,null,null,null,$sort); 

  }
 else if($filter == "Last Name" || $filter == "First Name"){

   unset($_POST['schoolSelect']);
    unset($_POST['trainingSelect']);
    $nameFilter = true;

  }

  if(isset($_POST['schoolSelect'])){
  // $filter = $_POST['filter'];
   // $sort = $_POST['sort'];
    $nameFilter = false;
    $trainingResult = null;

  $schoolSelect = $_POST['schoolSelect'];
  $schoolResult = $ac->getSchools();
  $selectedSchool =  $schoolSelect;
  if($schoolSelect != null){

    $result = $ac->getResultSummery(null,null,null,null,null,$schoolSelect,$sort); 

  }
}

if(isset($_POST['trainingSelect'])){
  // $filter = $_POST['filter'];
   // $sort = $_POST['sort'];
  $schoolResult = null; 
$nameFilter = false;

  $trainingSelect = $_POST['trainingSelect'];
  $trainingResult = $ac->getTrainings();
  $selectedTraining = $trainingSelect;
  if($trainingSelect != null){

   $result = $ac->getResultSummery($trainingSelect,null,null,null,null,null,$sort); 
 }

}

if(isset($_POST['nameSearch'])){


  if($_POST['nameSearch'] == null){
   $nameMsg = "Please enter name";

  }
  $trainingResult = null;
  $schoolResult = null;
   // $sort = $_POST['sort'];
 $nameFilter = true;
 // $filter = $_POST['filter'];
 $nameSearch = $_POST['nameSearch'];
 if($filter == "First Name"){
  $firstname = $nameSearch;
  $result = $ac->getResultSummery(null,null,null,$firstname,null,null,$sort); 
}
if($filter == "Last Name"){
  $lastname = $nameSearch;
  $result = $ac->getResultSummery(null,null,null,null,$lastname,null,$sort); 
}

}
}



}









?>

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


          <nav aria-label="breadcrumb" class="py-3">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
                   
                    <li class="breadcrumb-item active" aria-current="page">Check Results</li>
               </ol>
            </nav>
  <div id="customers" class="mt-1">

          <div class="row">
          <label class="col-sm-1 col-form-label" for="sort">Sort by:</label>
          <select id="sort" name="sort" class="form-control col-sm-1">
           
           <option <?php if ($sort == "Grade" ) echo 'selected' ; ?> value="Grade">Grade</option>
           <option <?php if($sort == "School")  echo 'selected' ; ?> value="School">School</option>
           <option <?php if ($sort == "First Name" ) echo 'selected' ; ?> value="First Name">First Name</option>
           <option <?php if ($sort == "Last Name" ) echo 'selected' ; ?> value="Last Name">Last Name</option>
           <option <?php if ($sort == "Date" ) echo 'selected' ; ?> value="Date">Date</option>

         </select> 
       

              &nbsp;&nbsp;
              <label class="col-sm-1 col-form-label" for="filter">Filter by:</label>
            <select id="filter" name="filter" class="form-control col-sm-2">
           <option <?php if ($filter == "All" ) echo 'selected' ; ?> value="All">All</option>
           <option <?php if ($filter == "Passed" ) echo 'selected' ; ?> value="Passed">Passed</option>
           <option <?php if ($filter == "Training") echo 'selected' ; ?> value="Training">Training</option>

           <option <?php if ($filter == "Failed" ) echo 'selected' ; ?> value="Failed">Failed</option>
           <option <?php if ($filter == "School" ) echo 'selected' ; ?> value="School">School</option>
           <option <?php if ($filter == "First Name" ) echo 'selected' ; ?> value="First Name">First Name</option>
           <option <?php if ($filter == "Last Name" ) echo 'selected' ; ?> value="Last Name">Last Name</option>

         </select> 

&nbsp;&nbsp;&nbsp;&nbsp;
        

      


        


         <?php


         if(isset($trainingResult)){ 
          if($trainingResult != null){

       
           echo"<br/>";

           echo'<label class="col-sm-1 col-form-label" for="trainingSelect">Select:</label>';
           echo '<select id="trainingSelect" placeholder ="Select Training" name="trainingSelect" class="form-control col-sm-3">';



           foreach($trainingResult as $rows){

            echo '<option  value="' . $rows['training_description'] . '" '.(($selectedTraining==$rows['training_description'])?'selected="selected"':"").'>' . $rows['training_description'] . '</option>';

          }



          echo"</select>";
        }
  
        echo'&nbsp;';
        
      }



      if(isset($schoolResult)){ 
        if($schoolResult != null){


         echo"<br/>";
         echo"<br/>";
         


echo'<label class="col-sm-1 col-form-label" for="trainingSelect">Select:</label>';
         echo '<select id="listSchools" placeholder ="Select School" name="schoolSelect" class="form-control col-sm-4">';



         foreach($schoolResult as $rows){


          echo '<option  value="' . $rows['school_name'] . '" '.(($selectedSchool==$rows['school_name'])?'selected="selected"':"").'>' . $rows['school_name'] . '</option>';
        }

        

        echo"</select>";
      }
echo'&nbsp;';
      
    }


    if(isset($nameFilter)){

      if($nameFilter){
        echo "<br/>";
        echo "<br/>";
        // echo'<div class="row">';
        if($filter == "First Name"){
        echo'<label class="col-sm-1.5 col-form-label" for="nameSearch">First Name :</label>';
        echo '<input type = "text" id = "nameSearch" name="nameSearch" placeholder = "Enter First name" class="form-control col-sm-2">';

        }else if($filter =="Last Name"){
        
       echo'<label  class="col-sm-1.5 col-form-label" for="nameSearch">Last Name :</label>';
        echo '<input type = "text" id = "nameSearch" name="nameSearch" placeholder = "Enter Last name" class="form-control col-sm-2">';

        }
         
         if(isset($nameMsg)){ 
echo '<script language="javascript">';
echo 'alert("No First Name found! All results will be displayed")';
echo '</script>';

       }
       echo'&nbsp;';

      }
    }
?>
 <input type="submit" name="submit" class="btn btn-success">
</div>
<?php

    if(isset($result)){ 
      if($result!=null){

        echo "<br/>";
        echo "<br/>";
        
      

        echo'<div id="customers">';
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
        echo"</div>";
      }else{
        echo"<br/>";
        echo"<br/>";
        echo '<p style="color:red;">No records found</p>';
      }
    } ?> 

  </form>
</div>
</div>
</body>
</html>
