<?php


class TrainingController {
	
	private $conn;
	
	function __construct() {
		require('dbConnection.php');
		$db = new DB();
		$this->conn = $db->get_connection();
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

//load training ids 
	function getTrainingModuleIds(){
		$results = array();
		
		try{

			$sql = "select training_id from trainings";
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

//load training description 
	function getTrainingModuleDesc($training_id){
		$results = array();
		
		try{

			$sql = "select training_description from trainings where training_id = :training_id";
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

//load exam ids 
	function getExamIds(){
		$results = array();
		
		try{

			$sql = "select exam_id from exams";
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

//load exam description 
	function getExamDesc($exam_id){
		$results = array();
		
		try{

			$sql = "select exam_description from exams where exam_id = :exam_id";
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

	//get if test should be loaded 
	function getExamComplete($exam_id, $guid){
		$result = FALSE;
		
		try{
			$sql = "select * from results where exam_id = :exam_id and guid = :guid and total_questions_answered_correctly/total_available_questions > .8";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);
			$stmt->bindValue(':guid', $guid, PDO::PARAM_STR);
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$result = TRUE;
			}
			if(!$result){
				$sql = "select * from results where exam_id = :exam_id and guid = :guid";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);
				$stmt->bindValue(':guid', $guid, PDO::PARAM_STR);
				$stmt->execute();
				$numtrys = 0;
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					$numtrys++;
				}
				if($numtrys >= 3){
					$result = TRUE;
				}
			}
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}

		return $result;

	}
}	