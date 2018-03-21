USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetAllTrainingModuleQuestionsAndAnswers`;

DELIMITER $

CREATE PROCEDURE `sp_GetAllTrainingModuleQuestionsAndAnswers`(
	IN	_training_id 	INT,
    OUT _return_value 	INT
)
BEGIN

	-- Setup a error handler
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;  							-- rollback any changes made in the transaction
		RESIGNAL;  							-- raise again the sql exception to the caller
        SET _return_value = MYSQL_ERRNO;	-- cleaner way to handle errors
	END;
    
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
    WHERE `exams`.`training_id` =  _training_id
    ORDER BY `questions`.`question_id`,`answers`.`answer_id`;
    
    SET _return_value = 0;
END$

DELIMITER ;