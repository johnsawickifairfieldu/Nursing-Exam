
<?php

require_once("ExamController.php");
$ec = new ExamController();


if (isset($_POST['submit']) && isset($_POST['question'])  && isset($_POST['radio']) ){

$questions = $_POST['question'];
  $answers = $_POST['radio'];

echo "Exam Over !";


  // for($i = 0 , $k = 0 ; $i<count($questions) , $k < count($answers); $i++, $k++ ){
  //   $ec->validateExam( $questions[$i] , $answers[$k] );
  // }
  // foreach ($questions as $question) {
  //  $question_val = $question;
  // }
  // foreach ($answers as $answer) {
  //   $answer_val = $answer;
    
  // }
 
  
}




?>

<html>
<head>
  <title>Nursing Exam</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
 
  <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
    <?php
    
    if(!empty($_POST['training_id'])){
     $training_id = $_POST['training_id'];

   $result = $ec->getExamId($training_id);
   foreach($result as $row){
     $exam_id = $row['exam_id'];
     $ec->setExamToActiveState($exam_id,$training_id);
     $ec->resetOtherExamsActiveState($exam_id);
     $question_id = array();
     $question_id = $ec->getQuestionId($exam_id,$training_id);
     $quesAns = array();
     
     $j = 0;
     foreach ($question_id as $row) {
      $quesAns = $ec->getAnswerId($row['question_id']);
      $question_answer_choices = array();
      foreach ($quesAns as $val) {
        $question_text = $val['question_text'];
        $answer_text = $val['answer_text'];
        $question_id_val = $val['question_id'];
        $answer_id_val = $val['answer_id'];
        array_push($question_answer_choices, $answer_id_val);
        array_push($question_answer_choices, $answer_text);
        
      }
      $j++;
      ?>
      <br/>
      <input type="hidden" name="question[<?php echo $j; ?>]" value="<?php echo $question_id_val; ?>" />
      <p> <?php echo " $question_text"; ?></p>
      <?php 

      for ($i = 0; $i < count($question_answer_choices); $i++) {
       
        ?>

        <input type="radio" name="radio[<?php echo $j; ?>]" value="<?php echo $question_answer_choices[$i]; ?>" required><?php echo $question_answer_choices[++$i]; ?><br/>
        <?php
      }
    }
    ?>
<br/>
    <input type="submit" name="submit" value="Submit">  

    <?php 
  }
}
  ?>

  
  
</form>

</body>
</html>
