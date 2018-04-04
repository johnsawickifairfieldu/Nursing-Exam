USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetIfUserExists`;

DELIMITER $

CREATE PROCEDURE `sp_GetIfUserExists`(
	IN	_email			varchar(250),
    OUT _return_value 	INT
)
BEGIN
	DECLARE vCount BIGINT;

	-- Setup a error handler
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;  							-- rollback any changes made in the transaction
		RESIGNAL;  							-- raise again the sql exception to the caller
        SET _return_value = MYSQL_ERRNO;	-- cleaner way to handle errors
	END;
    
	SELECT COUNT(*) INTO vCount FROM users WHERE email = _email;

	SELECT CASE WHEN vCount > 0 THEN 1 ELSE 0 END AS 'Value';
    
    SET _return_value = 0;
END$

DELIMITER ;