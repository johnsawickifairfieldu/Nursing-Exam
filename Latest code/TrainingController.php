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
}	