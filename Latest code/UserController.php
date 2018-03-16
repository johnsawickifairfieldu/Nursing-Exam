<?php


class UserController {
	
	private $conn;
	
	function __construct() {
		require('dbConnection.php');
		$db = new DB();
		$this->conn = $db->get_connection();
	}
	//User Login validation
	function validateLogin($email , $password){

		$results = array();
		//require('config.php');
		$valid = true;
		try{
			$query = "SELECT password_hashed FROM users WHERE email= :email ";

			$stmt = $this->conn->prepare($query);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);				
			$stmt->execute();
			while ($row = $stmt->fetch())
			{
				$password_hashed = $row[0];
			}

			if ( password_verify($password,$password_hashed)){
				
				$sql = "SELECT first_name ,last_name FROM users WHERE email= :email ";		
				$stmt = $this->conn->prepare($sql);
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
			//require('config.php');
			
			// Prepare the SQL statement and execute it
			$sql = "select fn_GetIfUserExists( :email )";
			$stmt = $this->conn->prepare($sql);
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
		//require('config.php');
		try{
			
			// Prepare the SQL statement and execute it
			$sql = "CALL sp_InsertUser(:guid , :email , :password_hashed , :firstname , :lastname , :school , :gradyear , :question1 , :answer1 ,
				:question2 , :answer2 ,  @_return_value)";
				$stmt = $this->conn->prepare($sql);
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
				
				
				
				array_push($results, array( "_return_value" => $this->conn->query("select @_return_value")->fetchAll(), "message" => ""));
				
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
		//require('config.php');
			try{
				
				$sql = "CALL sp_GetSchools(@returnval)";
				$stmt = $this->conn->prepare($sql);
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


		//load security questions
		function getSecurityQuestions(){
			$results = array();
		//require('config.php');
			try{
				
				$sql = "select secret_question from security_questions";
				$stmt = $this->conn->prepare($sql);
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
		
	//validate user security questions for forgot password 
		function securityQuestionsValidate( $email, $question1 , $answer1 , $question2 , $answer2 ){
			$results = array();
		//require('config.php');
			$reset = false;
			try{
				
				$query = "SELECT secret_question_1,secret_answer_1,secret_question_2,secret_answer_2 FROM users WHERE email= :email ";

				$stmt = $this->conn->prepare($query);
				$stmt->bindValue(':email', $email, PDO::PARAM_STR);				
				$stmt->execute();
				while ($row = $stmt->fetch())
				{
					$question_1 =$row[0];
					$answer_1 = $row[1];
					$question_2 =$row[2];
					$answer_2 = $row[3];
				}

				if ( ($question1 == $question_1 && $answer1 == $answer_1 && $question2 == $question_2 &&  $answer2 == $answer_2)
					|| ($question2 == $question_1 && $answer2 == $answer_1 && $question1 == $question_2 &&  $answer1 == $answer_2) ){
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
		//require('config.php');
		try{
			
			$sql = "UPDATE users SET password_hashed = :password WHERE email= :email ";
			$stmt = $this->conn->prepare($sql);
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


	//load training module links
	function getTrainingModuleLinks($training_id){
		$results = array();
		
		try{

			$sql = "CALL sp_GetTrainingModule(:training_id ,@returnval)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':training_id', $training_id, PDO::PARAM_STR);
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

//get exams id based on training module selected
	function getExamId($training_id){
		$results = array();
		
		try{

			$sql = "select exam_id from exams where training_id = :training_id";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':training_id', $training_id, PDO::PARAM_STR);
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

//if an exam is started set it to active state
	function setExamToActiveState($exam_id,$training_id){
		
		try{
			
			$sql = "UPDATE exams SET is_active = 1 WHERE exam_id= :exam_id and training_id = :training_id";
			$stmt = $this->conn->prepare($sql);	
			$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);	
			$stmt->bindValue(':training_id', $training_id, PDO::PARAM_STR);				
			$stmt->execute();
			$stmt->closeCursor();

			
			
			// Close connections
			$stmt = null;
			$connection = null;
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}
		
		
	}

        //reset previous exam active state to 0 if any
	function resetOtherExamsActiveState($exam_id){
		try{
			
			$sql = "UPDATE exams SET is_active = 0 WHERE exam_id <> :exam_id";
			$stmt = $this->conn->prepare($sql);	
			$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);	

			$stmt->execute();
			$stmt->closeCursor();
			
			// Close connections
			$stmt = null;
			$connection = null;
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}
	}

// 		function getTrainingModuleQuestionAndAnswers($training_id){
// $results = array();

// 			try{

// 				$sql = "CALL sp_GetAllTrainingModuleQuestionsAndAnswers(:training_id ,@_return_value)";
// 				$stmt = $this->conn->prepare($sql);
// 				$stmt->bindValue(':training_id', $training_id, PDO::PARAM_STR);
// 				$stmt->execute();

// 				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
// 					array_push($results, $row);

// 				}
// 			}
// 			catch (PDOException $e) {
// 				echo 'Exception: ' . $e->getMessage();
// 			}

// 			return $results;
// 		}

//load questions 
	function getQuestionId($exam_id,$training_id){
		$results = array();
		
		try{

			$sql = "select q.question_id from Questions q join exams e where e.exam_id = q.exam_id and e.training_id = :training_id and e.exam_id = :exam_id ";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':training_id', $training_id, PDO::PARAM_STR);
			$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);
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

//load answers for particular question
	function getAnswerId($question_id){
		$results = array();
		
		try{

			$sql = "select a.answer_text,q.question_text from answers a join questions q where a.question_id = q.question_id and q.question_id = :question_id";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':question_id', $question_id, PDO::PARAM_STR);
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
}	