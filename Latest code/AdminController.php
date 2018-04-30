<?php


class AdminController {
	
	private $conn;
	
	function __construct() {
		require('dbConnection.php');
		$db = new DB();
		$this->conn = $db->get_connection();
	}

	function getResultSummery($training_description,$exam_description,$status,$firstName,$lastName,$school,$sort){
		$results = array();
		

		if($sort == "Grade"){
			$sort = "grade";
			$sorting = "$sort DESC";
		}else if($sort == "School"){
			$sort = "u.school_name";
			$sorting = "$sort ASC";
		}else if($sort == "First Name"){
			$sort = "u.first_name";
			$sorting = "$sort ASC";

		}else if($sort == "Last Name"){
			
			$sort = "u.last_name";
			$sorting = "$sort ASC";
		}else if($sort == "Date"){
			
			$sort = "res.ended";
			$sorting = "$sort ASC";
		}else if($sort == null){
			$sort = "grade";
			$sorting = "$sort DESC";
		}
		

		try{
			if($training_description != null){

				$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
				res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id where tr.training_description = :training_description order by $sorting ";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindValue(':training_description', $training_description, PDO::PARAM_STR);

			}else if($exam_description != null){

				$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
				res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id where ex.exam_description = :exam_description order by $sorting ";
				$stmt = $this->conn->prepare($sql);
				$stmt->bindValue(':exam_description', $exam_description, PDO::PARAM_STR);

			}else if($status != null){

				if($status == 'Failed'){

					$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
					res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id where (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) < 0.30 order by $sorting ";
					$stmt = $this->conn->prepare($sql);

				}else if($status == 'Passed'){

					$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
					res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id where (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) > 0.30 order by $sorting ";
					$stmt = $this->conn->prepare($sql);


				}

			}

				else if($school != null){

					$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
					res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id where u.school_name = :school order by $sorting ";
					$stmt = $this->conn->prepare($sql);
					$stmt->bindValue(':school', $school, PDO::PARAM_STR);

				} 
                     
 				 else if($firstName != null){

					$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
					res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id where u.first_name = :firstName order by $sorting ";
					$stmt = $this->conn->prepare($sql);
					$stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);

				} 
				else if($lastName != null){

					$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
					res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id where u.last_name = :lastName order by $sorting ";
					$stmt = $this->conn->prepare($sql);
					$stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);

				}

			else{

				$sql = "select u.first_name , u.last_name , u.school_name , u.graduation_year , u.email , ex.exam_description , tr.training_description,tr.training_id ,ex.exam_id,
				res.ended , (res.total_questions_answered_correctly / nullif(res.total_available_questions,0)) grade from results res join users u on u.guid = res.guid join exams ex 
				on ex.exam_id = res.exam_id join trainings tr on tr.training_id = ex.training_id  order by $sorting ";
				$stmt = $this->conn->prepare($sql);
				


			}
			
			$stmt->execute();
			$count = $stmt->rowCount();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				array_push($results, $row);

			}
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
			error_log($e);
		}

		return $results;


	}

	function getTrainingsDescription($training_id){
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


	function getExamDescription($exam_id){
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


	function getTrainings(){
		$results = array();
		
		try{

			$sql = "select training_description from trainings";
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

	

	

	function getTrainingId($training_description){
		$results = array();
		
		try{

			$sql = "select training_id from trainings where training_description = :training_description";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':training_description', $training_description, PDO::PARAM_STR);	
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


	function getExams($training_id){
		$results = array();
		
		try{

			$sql = "select exam_description from exams where training_id = :training_id";
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

	function getExamId($exam_description){

		$results = array();
		
		try{

			$sql = "select exam_id from exams where exam_description = :exam_description";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':exam_description', $exam_description, PDO::PARAM_STR);	
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


	function getExamQuestions($exam_id){

		$results = array();
		
		try{

			$sql = "select question_text from questions where exam_id = :exam_id";
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

	function addQuesAns($exam_id,$question_text,$option1_text,$isCorrect1,$option2_text,$isCorrect2,$option3_text,$isCorrect3,$option4_text,$isCorrect4){
		$results = array();
		
		try{
			
			// Prepare the SQL statement and execute it
			$sql = "CALL sp_InsertQuestionAndAnswers(:exam_id,null,:question_text,null,:option1_text,:isCorrect1,null,:option2_text,:isCorrect2,null,:option3_text,:isCorrect3,null,:option4_text,:isCorrect4,@_return_value) ";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':exam_id', $exam_id, PDO::PARAM_STR);
			$stmt->bindValue(':question_text', $question_text, PDO::PARAM_STR);
			$stmt->bindValue(':option1_text', $option1_text, PDO::PARAM_STR);
			$stmt->bindValue(':isCorrect1', $isCorrect1, PDO::PARAM_INT);
			$stmt->bindValue(':option2_text', $option2_text, PDO::PARAM_STR);
			$stmt->bindValue(':isCorrect2', $isCorrect2, PDO::PARAM_INT);
			$stmt->bindValue(':option3_text', $option3_text, PDO::PARAM_STR);
			$stmt->bindValue(':isCorrect3', $isCorrect3, PDO::PARAM_INT);
			$stmt->bindValue(':option4_text', $option4_text, PDO::PARAM_STR);
			$stmt->bindValue(':isCorrect4', $isCorrect4, PDO::PARAM_INT);

			$stmt->execute();		
			$stmt->closeCursor();




			$stmt = null;
			$connection = null;

		} catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}

		return $results;
	}

	function getQuestionId($question_text){
		$results = array();
		
		try{

			$sql = "select question_id from questions where question_text = :question_text";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':question_text', $question_text, PDO::PARAM_STR);	
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



	function deleteQuestions($question_id){

		$isDeleted = false;
		
		try{

			$sql = "CALL sp_DeleteQuestionOrAnswer(:question_id,null,@_return_value)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':question_id', $question_id, PDO::PARAM_STR);	
			$stmt->execute();
			$count = $stmt->rowCount();
			if($count > 0){
				$isDeleted =  true;
			}

			
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}

		return $isDeleted;
	}

	function updateTrainingURL($training_id,$url){
		
		try{

			$sql = "update trainings set full_path_to_material =:url where training_id = :training_id";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':training_id', $training_id, PDO::PARAM_STR);	
			$stmt->bindValue(':url', $url, PDO::PARAM_STR);	
			$stmt->execute();

			$count = $stmt->rowCount();

				// Close connections
			$stmt = null;
			$connection = null;
		}
		catch (PDOException $e) {
			echo 'Exception: ' . $e->getMessage();
		}

		return $count;

	}



	function addTrainingMaterial($training_description,$url){
		
		try{

			$sql = "insert into trainings (training_id,training_description,full_path_to_material) select max(training_id)+1,:training_description,:url from trainings;";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindValue(':training_description', $training_description, PDO::PARAM_STR);
			$stmt->bindValue(':url', $url, PDO::PARAM_STR);	
			$stmt->execute();
			$count = $stmt->rowCount();

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

