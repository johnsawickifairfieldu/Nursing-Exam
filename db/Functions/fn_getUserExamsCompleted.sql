USE db_team2;

DROP FUNCTION IF EXISTS fn_GetUserExamsCompleted;

DELIMITER $

CREATE FUNCTION fn_GetUserExamsCompleted(_guid VARCHAR(36), _exam_id INT)
RETURNS INT
BEGIN

	DECLARE vCount INT default 0;

	SELECT COUNT(*) INTO vCount FROM results WHERE guid = _guid AND exam_id = _exam_id;

	RETURN vCount;

END$

DELIMITER ;
 