USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetTrainingModuleNextQuestionAndAnswer`;

DELIMITER $

CREATE PROCEDURE `sp_GetTrainingModuleNextQuestionAndAnswer`(
	IN	_training_id 			INT,
    IN	_previous_question_id 	INT, # pass in NULL or 0 if requesting first question
    OUT _return_value 			INT
)
BEGIN
	DECLARE next_question_id INT;

	-- Setup a error handler
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;  							-- rollback any changes made in the transaction
		RESIGNAL;  							-- raise again the sql exception to the caller
        SET _return_value = MYSQL_ERRNO;	-- cleaner way to handle errors
	END;    
    
    IF IFNULL(_previous_question_id, 0) = 0 THEN
   		SET next_question_id = 
		(SELECT MIN(`questions`.`question_id`)
		FROM `questions`
		JOIN `exams` ON `exams`.`exam_id` = `questions`.`exam_id`
		WHERE `exams`.`training_id` =  _training_id AND `exams`.`is_active` = 1);
    ELSE
    	SET next_question_id = _previous_question_id + 1;
    END IF;
    
	SELECT 
		`questions`.`question_id`,
        `questions`.`question_text`,
        `exams`.`exam_id`,
        `exams`.`exam_description`,
        `answers`.`answer_id`,
        `answers`.`answer_text`,
        `answers`.`is_correct_answer`
	FROM `questions`
    JOIN `exams` ON `exams`.`exam_id` = `questions`.`exam_id`
    JOIN `answers` ON `answers`.`question_id` = `questions`.`question_id`
    WHERE `exams`.`training_id` =  _training_id AND `exams`.`is_active` = 1
    AND `questions`.`question_id` = next_question_id
    ORDER BY `answers`.`answer_id`;
    
    SET _return_value = 0;
END$

DELIMITER ;