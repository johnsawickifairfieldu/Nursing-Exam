USE db_team2;

DROP PROCEDURE IF EXISTS `sp_InsertUserExamResults`;

DELIMITER $

CREATE PROCEDURE `sp_InsertUserExamResults`(
	IN _guid				VARCHAR(36),
	IN _exam_id				INT,
	IN _total_questions		INT,
    IN _correct_questions 	INT,
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
    
    IF _correct_questions > _total_questions THEN
		SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Correct questions cannot be more than total questions!';
	END IF;
        
	INSERT INTO `results`(
		`results`.`guid`,
		`results`.`exam_id`,
        `results`.`ended`,
		`results`.`total_available_questions`,
		`results`.`total_questions_answered_correctly`)
	VALUES(
		_guid,
		_exam_id,
		now(),
		_total_questions,
        _correct_questions);
    
    SET _return_value = 0;
END$

DELIMITER ;