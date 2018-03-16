USE db_team2;

DROP PROCEDURE IF EXISTS `sp_GetTrainingModule`;

DELIMITER $

CREATE PROCEDURE `sp_GetTrainingModule`(
	IN	_training_id 	INT,
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
		`trainings`.`full_path_to_material`
	FROM `trainings`
    WHERE `trainings`.`training_id` =  _training_id;
    
    SET _return_value = 0;
END$

DELIMITER ;