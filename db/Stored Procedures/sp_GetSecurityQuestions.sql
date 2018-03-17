USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetSecurityQuestions`;

DELIMITER $

CREATE PROCEDURE `sp_GetSecurityQuestions`(
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
    
	SELECT secret_question FROM security_questions;
    
    SET _return_value = 0;
END$

DELIMITER ;