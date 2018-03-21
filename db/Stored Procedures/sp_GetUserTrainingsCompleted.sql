USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetUserTrainingsCompleted`;

DELIMITER $

CREATE PROCEDURE `sp_GetUserTrainingsCompleted`(
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
		tr.training_id,
        CASE WHEN com.training_id IS NULL THEN 0 ELSE 1 END completed
    FROM trainings tr
    LEFT JOIN user_trainings_completed com ON com.training_id = tr.training_id AND com.guid = _guid;
    
    SET _return_value = 0;
END$

DELIMITER ;