USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetUserExamsCompleted`;

DELIMITER $

CREATE PROCEDURE `sp_GetUserExamsCompleted`(
	IN _guid VARCHAR(36),
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
		ex.exam_id,
        CASE WHEN com.exam_id IS NULL THEN 0 ELSE 1 END completed
    FROM exams ex
    LEFT JOIN user_exams_completed com ON com.exam_id = ex.exam_id AND com.guid = _guid;
    
    SET _return_value = 0;
END$

DELIMITER ;