<?php


	class UserController {
		
		//User Login validation
		function validateLogin($email , $password){

			$results = array();
			require('config.php');
			$valid = true;
			try{
			$query = "SELECT password_hashed FROM users WHERE email= :email ";
 
	$stmt = $connection->prepare($query);
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);				
				$stmt->execute();
	while ($row = $stmt->fetch())
    {
		$password_hashed = $row[0];
    }
	
	if ( password_verify($password,$password_hashed)){
		
$sql = "SELECT first_name ,last_name FROM users WHERE email= :email ";		
		$stmt = $connection->prepare($sql);
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);				
				$stmt->execute();	
		while ($row = $stmt->fetch())
		{
			$_SESSION['firstname'] = $row[0];
			$_SESSION['lastname'] = $row[1];
			
		}
	}else{
		
		$valid = false;
	}
			}
			catch (PDOException $e) {
				 echo 'Exception: ' . $e->getMessage();
			}
			
			return $valid;
		}
		
		
		
		//checking for existing user
		function ifUserExists($email)
		{
			try{
				$exist = false;
				require('config.php');
				
				// Prepare the SQL statement and execute it
				$sql = "select fn_GetIfUserExists( :email )";
				$stmt = $connection->prepare($sql);
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);				
				$stmt->execute();
				
				while ($row = $stmt->fetch()){
					if($row[0] == 1){
						$exist = true;
					}
					
				}
				
				$stmt->closeCursor();
				
				// Close connections
				$stmt = null;
				$connection = null;
				
			} catch (PDOException $e) {
				echo "Exception: ".$e->getMessage();
				
			}
			
			return $exist;
		}			
		
		//insert new user details
		function insertUser( $guid , $email , $password_hashed , $firstname , $lastname , $school , $gradyear , $question1 , $answer1 , $question2 , $answer2 ){
			$results = array();
			require('config.php');
			try{
				
				// Prepare the SQL statement and execute it
				$sql = "CALL sp_InsertUser(:guid , :email , :password_hashed , :firstname , :lastname , :school , :gradyear , :question1 , :answer1 ,
				        :question2 , :answer2 ,  @_return_value)";
				$stmt = $connection->prepare($sql);
				$stmt->bindValue(':guid', $guid, PDO::PARAM_STR);
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);
				$stmt->bindValue(':password_hashed', $password_hashed, PDO::PARAM_STR);
				$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
				$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
				$stmt->bindValue(':school', $school, PDO::PARAM_STR);
				$stmt->bindValue(':gradyear', $gradyear, PDO::PARAM_STR);
				$stmt->bindValue(':question1', $question1, PDO::PARAM_STR);
				$stmt->bindValue(':answer1', $answer1, PDO::PARAM_STR);
				$stmt->bindValue(':question2', $question2, PDO::PARAM_STR);
				$stmt->bindValue(':answer2', $answer2, PDO::PARAM_STR);
				$stmt->execute();		
                $stmt->closeCursor();
				
				
				
				array_push($results, array( "_return_value" => $connection->query("select @_return_value")->fetchAll(), "message" => ""));
				
				// Close connections
				$stmt = null;
				$connection = null;
				
			} catch (PDOException $e) {
				 echo 'Exception: ' . $e->getMessage();
			}
			
			return $results;
		}
		
		//load school names
		function getSchools(){
			$results = array();
			require('config.php');
			try{
			
			$sql = "select school_name from schools";
  $stmt = $connection->prepare($sql);
 $stmt->execute();

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					array_push($results, $row);
					
				}
			}
			catch (PDOException $e) {
				 echo 'Exception: ' . $e->getMessage();
			}
			
				return $results;
				
  
		}
		
		//validate user for forgot password 
		function securityQuestionsValidate( $email, $answer1 , $answer2 ){
			$results = array();
			require('config.php');
			$reset = false;
			try{
			
			$query = "SELECT secret_answer_1,secret_answer_2 FROM users WHERE email= :email ";
 
	$stmt = $connection->prepare($query);
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);				
				$stmt->execute();
	while ($row = $stmt->fetch())
    {
		$answer_1 = $row[0];
		$answer_2 = $row[1];
    }
	
	if ( $answer1 == $answer_1 && $answer2 == $answer_2){
      $reset = true;
	}
			}
			catch (PDOException $e) {
				 echo 'Exception: ' . $e->getMessage();
			}
			
				return $reset;
		}
		
		//update new password
		function resetPassword($email , $password){
			$results = array();
			require('config.php');
			try{
			
			$sql = "UPDATE users SET password_hashed = :password WHERE email= :email ";
            $stmt = $connection->prepare($sql);
			$stmt->bindValue(':password', $password, PDO::PARAM_STR);	
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);				
				$stmt->execute();
				$count = $stmt->rowCount();
				$stmt->closeCursor();
				
				// Close connections
				$stmt = null;
				$connection = null;
			}
			catch (PDOException $e) {
				 echo 'Exception: ' . $e->getMessage();
			}
			
				return $count;
		}
	}	