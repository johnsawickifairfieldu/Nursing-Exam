USE nursing;

DROP PROCEDURE IF EXISTS `sp_GetSchools`;

DELIMITER $

CREATE PROCEDURE `sp_GetSchools`(
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
    
	SELECT school_name FROM schools;
    
    SET _return_value = 0;
END$

DELIMITER ;