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