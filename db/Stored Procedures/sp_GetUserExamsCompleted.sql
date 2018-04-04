USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetUserExamsCompleted`;

DELIMITER $

CREATE PROCEDURE `sp_GetUserExamsCompleted`(
	IN	_guid			varchar(36),
    IN	_exam_id		INT,
    OUT _return_value 	INT
)
BEGIN
	DECLARE vCount INT default 0;

	-- Setup a error handler
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;  							-- rollback any changes made in the transaction
		RESIGNAL;  							-- raise again the sql exception to the caller
        SET _return_value = MYSQL_ERRNO;	-- cleaner way to handle errors
	END;
    
	SELECT COUNT(*) INTO vCount FROM results WHERE guid = _guid AND exam_id = _exam_id;

	SELECT vCount AS 'Value';
    
    SET _return_value = 0;
END$

DELIMITER ;