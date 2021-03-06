
<?php
 session_start();
require_once("ExamController.php");
require_once("sendmail.php");
$ec = new ExamController();


if (isset($_POST['submit']) && isset($_POST['question'])  && isset($_POST['radio']) && isset($_POST['exam_id']) ){

$exam_id = $_POST['exam_id'];
$questions = $_POST['question'];
  $answers = $_POST['radio'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];

  //load correct answers from database
$result = $ec->getCorrectAnswers($exam_id);

$ques = array();
$ans = array();

//changing the question,answers array format loaded from database to match that of current exam taken by user
foreach ($result as $key1 => $value1) {
  foreach ($value1 as $key => $value) {
if($key == "question_id"){
array_push($ques, $value);
  }else if($key == "answer_id"){
array_push($ans, $value);
  }
}
}

//question, answers loaded from database
$dbQuesAns = array_combine( $ques , $ans );

//question, answers from the user
$userQuesAns = array_combine( $questions , $answers );

//checks if question id's are same
if(count(array_diff_key($dbQuesAns, $userQuesAns)) == 0){
$correct = count(array_intersect($dbQuesAns, $userQuesAns));
$wrong = count(array_diff($dbQuesAns, $userQuesAns));

}

$guid = $ec->getGUID($email);

//$email = $ec->getEMAIL($firstname , $lastname);

$total = $correct + $wrong;
$score = ($correct / $total)*100;
$message = "<html><body>Hello ".$firstname.",<br><br>";
$message .= "We want to let you know your test results for exam ".$exam_id.".<br><br>";
$message .= $score>80?"Congratulations!":"Better Luck Next Time";
$message .= "<br>You completed ".$total." questions<br>";
$message .= "You answered ".$correct." questions correct<br>";
$message .= "You answered ".$wrong." questions incorrect<br>";
$message .= "For a score of ".$score."%<br><br>";
$message .= "Thank you for taking the exam.<br>We strive to provide the best training possible.<br>CT Nurse Training</body></html>";
$title = "CT Nursing Exam ".$exam_id." results";
sendEmail($email, $title, $message, true);

$ec->InsertExamResults($guid,$exam_id,($correct + $wrong) , $correct);

$msg = "Exam Completed!";
  
}




?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>CT Nurse Training</title>

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
  <a href="#" class="navbar-brand">Ct NURSE TRAINING</a>
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
   
            if(isset($_SESSION['firstname']) && isset($_SESSION['lastname'])){
              $firstname = $_SESSION['firstname'];
               $lastname = $_SESSION['lastname'];
            echo " Welcome $firstname $lastname";
            }
            if(isset($_SESSION['email'])){
              $email = $_SESSION['email'];
            }
            ?>
<input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
<input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
<input type="hidden" name="email" value="<?php echo $email; ?>">
            
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          
        </div>
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
                     <a href="TrainingModule.php">   <!--  data-toggle="collapse" aria-expanded="false" -->
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
                            <?php
                            $training_ids = $ec->getTrainingModuleIds();
                            $user_guid = $ec->getGUID($_SESSION['email']);
                            for($index = 0;$index<count($training_ids);$index++){
                              $mat_id = $training_ids[$index]["training_id"];
                              $training_desc = $ec->getTrainingModuleDesc($mat_id);
                              if(!$ec->getExamComplete($mat_id, $user_guid))
                                echo '<li><a href="TrainingMaterial.php?training_id='.$mat_id.'">Material '.$training_desc[0]["training_description"].'</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="active">
                        <a href="#testSubmenu"  data-toggle="collapse" aria-expanded="false">
                            <i class="fa fa-pencil"></i>
                            Tests <i class="fa fa-angle-down"></i>
                        </a>
                         <ul class="collapse list-unstyled" id="testSubmenu">
                            <?php
                            $exam_ids = $ec->getExamIds();
                            for($index = 0;$index<count($exam_ids);$index++){
                              $mat_id = $exam_ids[$index]["exam_id"];
                              $exam_desc = $ec->getExamDesc($mat_id);
                              if(!$ec->getExamComplete($mat_id, $user_guid))
                                echo '<li><a href="ExamHandler.php?training_id='.$mat_id.'">Test '.$exam_desc[0]["exam_description"].'</a></li>';
                            }
                            ?>
                        </ul></li>
               
                  
                    <li>
                        <a href="contactPage.php">
                            <i class="fa fa-send"></i>
                            Contact Us</i>
                        </a>
            
                </ul>

              
            </nav>

            <!-- Page Content Holder -->
            <div id="content">

               
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
    <?php
    
    if(!empty($_GET['training_id'])){
       $training_id = $_GET['training_id'];
     }elseif(!empty($_POST['training_id'])){
     $training_id = $_POST['training_id'];
   }

 $guid = $ec->getGUID($email);
  

     if(!empty($training_id)){

   $result = $ec->getExamId($training_id);
   foreach($result as $row){
     $exam_id = $row['exam_id'];
     $question_id = array();
     $question_id = $ec->getQuestionId($exam_id,$training_id);
     //shuffle questions
     shuffle($question_id);
     $quesAns = array();
      $countExceeded = $ec->countAttempts($guid , $exam_id);
     $j = 0;
     $quesCount = 0;
     if(!$countExceeded){
     foreach ($question_id as $row) {
      $quesAns = $ec->getAnswerId($row['question_id']);
//Shuffle Answers
      shuffle($quesAns);
      $question_answer_choices = array();
      shuffle($question_answer_choices);
      foreach ($quesAns as $val) {
        $question_text = $val['question_text'];
        $answer_text = $val['answer_text'];
        $question_id_val = $val['question_id'];
        $answer_id_val = $val['answer_id'];
        array_push($question_answer_choices, $answer_id_val);
        array_push($question_answer_choices, $answer_text);
        
      }
      $j++;
      $quesCount = $quesCount + 1;
      ?>
      <br/>
      
    <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" />
    
      <input type="hidden" name="question[<?php echo $j; ?>]" value="<?php echo $question_id_val; ?>" />
      <p> <?php echo " $quesCount. $question_text"; ?></p>
      <?php 
      for ($i = 0; $i < count($question_answer_choices); $i++) {
       
        ?>

        <input type="radio" name="radio[<?php echo $j; ?>]" value="<?php echo $question_answer_choices[$i]; ?>" required><?php echo $question_answer_choices[++$i]; ?><br/>
        <?php
      }
    }
    ?>
      <br/>
    <input type="submit" class="btn btn-success" name="submit" value="Submit">  
      <?php
  }else{
    ?>
<p>You cannot take test more than 3 times.</p>
    <?php
  }
  ?>


    <?php 
  }
}


?>



  
</form>

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

         <script>

window.location.hash="no-back-button";

window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history

window.onhashchange=function(){window.location.hash="no-back-button";}

</script>
    </body>
</html>
