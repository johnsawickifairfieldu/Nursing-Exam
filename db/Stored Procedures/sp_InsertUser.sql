USE db_team2;

DROP PROCEDURE IF EXISTS `sp_InsertUser`;

DELIMITER $

CREATE PROCEDURE `sp_InsertUser`(
	IN _guid				VARCHAR(36),
	IN _email				VARCHAR(250),
	IN _password_hashed 	VARCHAR(255),
    IN _first_name 			VARCHAR(100),
	IN _last_name 			VARCHAR(100),
	IN _school_name 		VARCHAR(200),
	IN _graduation_year 	CHAR(4),
    IN _secret_question_1 	VARCHAR(200),
    IN _secret_answer_1		VARCHAR(50),
    IN _secret_question_2	VARCHAR(200),
    IN _secret_answer_2		VARCHAR(50),
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
    
    -- If the record exists in the issue_tracker table updated else add it to the table
    IF EXISTS(SELECT 1 FROM users e WHERE e.guid = _guid) THEN
		UPDATE 
			`users`
		SET
			`users`.`email` 				= _email,
            `users`.`password_hashed` 		= _password_hashed,
			`users`.`first_name`	 		= _first_name,
			`users`.`last_name`	 			= _last_name,
			`users`.`school_name`	 		= _school_name,
            `users`.`graduation_year`		= _graduation_year,
            `users`.`secret_question_1`		= _secret_question_1,
            `users`.`secret_answer_1`		= _secret_answer_1,
            `users`.`secret_question_2`		= _secret_question_2,            
            `users`.`secret_answer_2`		= _secret_answer_2
		WHERE
			`users`.`guid` = _guid;
    ELSE
		INSERT INTO `users`(
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
            `users`.`secret_answer_2`)
		VALUES(
			_guid,
			_email,
            _password_hashed,
			_first_name,
			_last_name,
			_school_name,
            _graduation_year,
            _secret_question_1,
            _secret_answer_1,
            _secret_question_2,
            _secret_answer_2);
	END IF;
    
    SET _return_value = 0;
END$

DELIMITER ;