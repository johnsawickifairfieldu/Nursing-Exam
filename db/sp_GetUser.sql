USE nursing;

DROP PROCEDURE IF EXISTS `sp_GetUser`;

DELIMITER $

CREATE PROCEDURE `sp_GetUser`(
	IN	_email VARCHAR(250),
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
		`users`.`guid`,
		`users`.`email`,
		`users`.`password_hashed`,
		`users`.`first_name`,
		`users`.`last_name`,
		`users`.`school_name`,
		`users`.`graduation_year`,        
		`users`.`secret_question_1`,
		`users`.`secret_answer_1`,
		`users`.`secret_question_2`,            
		`users`.`secret_answer_2`,
		`users`.`access_level`,
		`users`.`is_active`,
		`users`.`created`
	FROM `users`
    WHERE `users`.`email` =  _email;
    
    SET _return_value = 0;
END$

DELIMITER ;