<?php


class ExamController {
	
	private $conn;
	
	function __construct() {
		require('dbConnection.php');
		$db = new DB();
		$this->conn = $db->get_connection();
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




//load questions 
	function getQuestionId($exam_id,$training_id){
		$results = array();
		
		try{

			$sql = "select q.question_id from questions q join exams e where e.exam_id = q.exam_id and e.training_id = :training_id and e.exam_id = :exam_id ";
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

			$sql = "select a.answer_text,q.question_text, a.answer_id, q.question_id from answers a join questions q where a.question_id = q.question_id and q.question_id = :question_id";
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

	function getCorrectAnswers($exam_id){
		$results = array();
		
		try{

		$sql = "select a.question_id,a.answer_id from answers a join questions q where a.question_id = q.question_id and q.exam_id = :exam_id and a.is_correct_answer = 1";
		$stmt = $this->conn->prepare($sql);
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

	function getGUID($email){

		try{

		$sql = "select guid from users where email = :email and is_active = 1";
		$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);
			$stmt->execute();
             $result = $stmt->fetch(PDO::FETCH_ASSOC);
			$guid = $result['guid'];
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}

		return $guid;
	}


	function getEMAIL($firstname , $lastname){

		try{

 		$sql = "select email from users where first_name = :firstname and last_name = :lastname and is_active = 1";
		$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
			$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
			$stmt->execute();
             $result = $stmt->fetch(PDO::FETCH_ASSOC);
			$email = $result['email'];
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}

	return $email;
	}


	function InsertExamResults($guid,$exam_id,$total , $correct){

$results = array();
		
		try{
			
			// Prepare the SQL statement and execute it
			$sql = "CALL sp_InsertUserExamResults(:guid , :exam_id , :total , :correct , @_return_value)";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindValue(':guid', $guid, PDO::PARAM_STR);
				$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);
				$stmt->bindValue(':total', $total, PDO::PARAM_STR);
				$stmt->bindValue(':correct', $correct, PDO::PARAM_STR);
				
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

	function countAttempts($guid , $exam_id){
		try{
            $exceededAttempts = false;
			// Prepare the SQL statement and execute it
			$sql = "call sp_GetUserExamsCompleted(:guid,:exam_id,@return_value)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':guid', $guid, PDO::PARAM_STR);
			$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);				
			$stmt->execute();
			
		while ($row = $stmt->fetch())
				{
					$count =$row[0];
					
				}

			if($count >= 3){
				$exceededAttempts = true;
			}
			
			$stmt->closeCursor();
			
			// Close connections
			$stmt = null;
			$connection = null;
			
		} catch (PDOException $e) {
			echo "Exception: ".$e->getMessage();
			
		}
		
		return $exceededAttempts;
	}
}	