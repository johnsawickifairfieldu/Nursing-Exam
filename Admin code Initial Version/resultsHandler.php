
<?php
session_start();
require_once("AdminController.php");
$ac = new AdminController();


if (isset($_POST['submit']) && isset($_POST['question'])  && isset($_POST['radio']) ){
$exam_id = $_POST['exam_id'];
$questions = $_POST['question'];
  $answers = $_POST['radio'];

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
     $result = $ac->getResultSummery();
echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>School</th><th>First name</th><th>Last name</th><th>Grade</th></tr>";
     foreach($result as $row){
      $first = $row['first_name'];
        echo "<tr>";
        echo "<td>".$row['school_name']."</td>";
        echo "<td>".$row['first_name']. "</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['grade']."</td>";
        echo "</tr>";
    }
      echo "</table>";
    ?>
  
</form>

</body>
</html>
