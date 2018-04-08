
<?php
session_start();
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
    echo "deleted succesfully";
  }
  

}else{

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
      if(!empty($_GET['exam_id'])){
       $exam_id = $_GET['exam_id'];
     }
     
     ?>

     <div >
      <p>
        <p>Select questions to be deleted<br/>
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

      </p><br/>
    </div>




    <input type="submit" name="submit">

  </form>

</body>
</html>
<?php
}
?>