
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
    <p>All students results</p>
    <a href="resultsHandler.php?results=all">All results</a><br/>
    <p>Trainings</p>
    <a href="resultsHandler.php?training_id=1">Training Module 1</a><br/>
    <a href="resultsHandler.php?training_id=2">Training Module 2</a><br/>
    <a href="resultsHandler.php?training_id=3">Training Module 3</a><br/>
    <p>Exams</p>
    <a href="resultsHandler.php?exam_id=1">Test 1</a><br/>
    <a href="resultsHandler.php?exam_id=2">Test 2</a><br/>
    <a href="resultsHandler.php?exam_id=3">Test 3</a><br/>
    <p>Result Status</p>
    <a href="resultsHandler.php?status=passed">Passed</a><br/>
    <a href="resultsHandler.php?status=failed">Failed</a><br/>
    <p>Search</p>
    <a href="resultsSearch.php?search=school">Scool Name</a><br/>
    <a href="resultsSearch.php?search=firstname">First Name</a><br/>
    <a href="resultsSearch.php?search=lastname">Last Name</a><br/>
  </form>

</body>
</html>
