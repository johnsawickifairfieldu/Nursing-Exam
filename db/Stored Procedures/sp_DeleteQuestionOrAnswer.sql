USE db_team2;

DROP PROCEDURE IF EXISTS `sp_DeleteQuestionOrAnswer`;

DELIMITER $

CREATE PROCEDURE `sp_DeleteQuestionOrAnswer`(
	IN _question_id			INT, #deletes question and all associated answers (ignored if null or invalid)
    IN _answer_id			INT, #deletes answer (ignored if null or invalid)
    OUT _return_value 		INT
)
BEGIN

	-- Setup a error handler
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;  							-- rollback any changes made in the transaction
		RESIGNAL;  							-- raise again the sql exception to the caller
        SET _return_value = MYSQL_ERRNO;	-- cleaner way to handle errors
	END;
    
    DELETE FROM answers WHERE answer_id = _answer_id;
    
    DELETE a
    FROM answers a
    JOIN questions q on q.question_id = a.question_id
    WHERE q.question_id = _question_id;
    
    DELETE FROM questions WHERE question_id = _question_id;
    
    SET _return_value = 0;
END$

DELIMITER ;