
<html>
<head>
  <title>Nursing Exam</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

  <form class="form" method="post" action="resultsHandler.php"> 
    <?php if(isset($msg)){ ?><div role="alert"> <?php echo $msg; ?> </div><?php } ?> 
    <?php

    session_start();
    require_once("AdminController.php");
    $ac = new AdminController();


    if(isset($_GET['search'])){
      $search = $_GET['search'];
    }

    if($search != null){
      if($search == 'school'){
        ?>
        <input type="search" name="school"  autocomplete="off" required="required" placeholder="Enter school" list="listSchools">
        <input type="hidden" name="search" value="school">
        <datalist id="listSchools">



          <?php
              //load schools from database
          $result = $ac->getSchools();

          foreach($result as $row){

            echo "<option value='" . $row['school_name'] . "'>" . $row['school_name'] . "</option>";
          }

          ?>

        </datalist> 
        <?php
      } else if($search == 'firstname'){
        ?>
        <input type="text" name="firstname" placeholder="Enter First Name">
        <input type="hidden" name="search" value="firstname">
        <?php

      }else if($search == 'lastname'){

        ?>
        <input type="text" name="lastname" placeholder="Enter Last Name">
        <input type="hidden" name="search" value="lastname">
        <?php

      }

      ?>

      <input type="submit" name="submit">
      <?php
    }
    ?>
  </form>

</body>
</html>
