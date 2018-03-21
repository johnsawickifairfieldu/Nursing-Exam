
<?php

require_once("ExamController.php");
$ec = new ExamController();


if (isset($_POST['submit']) && isset($_POST['question'])  && isset($_POST['radio']) && isset($_POST['exam_id']) ){

$exam_id = $_POST['exam_id'];
$questions = $_POST['question'];
  $answers = $_POST['radio'];
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
}else{
  echo "questions don't match!";
}

//display number of correct and wrong answers
echo "$correct correct and $wrong wrong answers";
 
  
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
	  <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" />
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
