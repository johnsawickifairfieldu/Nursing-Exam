
<?php

require_once("AdminController.php");
$ac = new AdminController();
if (isset($_POST['submit']) && isset($_POST['questions'])){
  $question_id_array = array();
  $questions = $_POST['questions'];
  foreach ($questions as $row) {
    $result = $ac->getQuestionId($row);
    array_push($question_id_array, $result);
  }
 // print_r($question_id_array);
  $isDelete_array = array();
  foreach ($question_id_array as $row) {
    foreach ($row as $val) {
      $result = $ac->deleteQuestions($val['question_id']);
      array_push($isDelete_array, $result);
    }
  }

  if(count(array_unique($isDelete_array)) == 1){
   // echo "deleted succesfully";
    $msg = "deleted succesfully";
      $url = "AdminPage.php?msg=$msg";
      header("Location: ".$url);
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


    <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
      <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
      <?php
      if(!empty($_GET['exam_id'])){
       $exam_id = $_GET['exam_id'];
     }
     
     ?>
<nav aria-label="breadcrumb" class="py-3">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item" aria-current="page"><a href="AdminPage.php" >Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="AdminActions.php?deleteQues=Y"> Delete Q&A </a></li>
                     <li class="breadcrumb-item" aria-current="page"><a href="AdminActions2.php?deleteQues=Y">Select Exam </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Select Questions</li>
               </ol>
            </nav>


     <div class="container" >
      
        <p><h4>Select questions to be deleted</h4>
          Note: Questions and their corresponding answers will be deleted.
        </p>
        <?php
        $j = 0;
        $result = $ac->getExamQuestions($exam_id);
        foreach ($result as $row) {
          $j++;
          ?>

          <input type="checkbox" name="questions[<?php echo $j; ?>]" value="<?php echo $row['question_text']; ?>" > <?php echo $row['question_text']; ?><br>
          
          <?php
        }
        ?>

      <br/>
    </div>




   </br></br>
      <div class="container text-center">

      <input type="submit" class="btn btn-success" name="submit">

      </div>

  </form>
</div>
</div>
</body>
</html>
<?php
}
?>