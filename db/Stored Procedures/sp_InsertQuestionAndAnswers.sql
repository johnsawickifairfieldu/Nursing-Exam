USE db_team2;

DROP PROCEDURE IF EXISTS `sp_InsertQuestionAndAnswers`;

DELIMITER $

CREATE PROCEDURE `sp_InsertQuestionAndAnswers`(
	IN _exam_id				INT, #cannot be null
	IN _question_id			INT, #pass in null to insert new question or valid question_id to update (invalid ids will do nothing)
    IN _question_text		TEXT, #the text of the new question or updated text of existing question (ignored if null)
    IN _answer_id_1 		INT, #pass in not null valid answer_id to update (ignored if inserting new question or invalid id)
    IN _answer_text_1		TEXT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    IN _answer_is_correct_1	BIT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    IN _answer_id_2			INT, #pass in not null valid answer_id to update (ignored if inserting new question or invalid id)
    IN _answer_text_2		TEXT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    IN _answer_is_correct_2	BIT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    IN _answer_id_3			INT, #pass in not null valid answer_id to update (ignored if inserting new question or invalid id)
    IN _answer_text_3		TEXT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    IN _answer_is_correct_3	BIT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    IN _answer_id_4			INT, #pass in not null valid answer_id to update (ignored if inserting new question or invalid id)
    IN _answer_text_4		TEXT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    IN _answer_is_correct_4	BIT, #used to either update an existing answer or insert an answer for a new question (ignored if null)
    OUT _return_value 		INT
)
BEGIN
    
    DECLARE local_question_id INT DEFAULT NULL;
    DECLARE local_answer_id INT DEFAULT NULL;

	-- Setup a error handler
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		ROLLBACK;  							-- rollback any changes made in the transaction
		RESIGNAL;  							-- raise again the sql exception to the caller
        SET _return_value = MYSQL_ERRNO;	-- cleaner way to handle errors
	END;
    
    IF ISNULL(_question_id) THEN
		SET local_question_id = (SELECT MAX(question_id) FROM questions) + 1;
        SET local_answer_id = (SELECT MAX(answer_id) FROM answers) + 1;
        
        IF ISNULL(local_question_id) THEN
			SET local_question_id = 1;            
        END IF;
        
        IF ISNULL(local_answer_id) THEN
			SET local_answer_id = 1;
        END IF;
    ELSE
		SET local_question_id = _question_id;
    END IF;    
    
    IF IFNULL(local_question_id,'X') <> IFNULL(_question_id,'Y') THEN 
    
		INSERT INTO questions (
			question_id,
			question_text,
			exam_id)
		VALUES(
			local_question_id,
			_question_text,
			_exam_id);
            
		IF ISNULL(_answer_text_1) = 0 THEN
			INSERT INTO answers (
				answer_id,
                answer_text,
                question_id,
                is_correct_answer
            )
            VALUES(
				local_answer_id,
                _answer_text_1,
                local_question_id,
                _answer_is_correct_1
            );
            
            SET local_answer_id = local_answer_id + 1;
        END IF;
        
        IF ISNULL(_answer_text_2) = 0 THEN
			INSERT INTO answers (
				answer_id,
                answer_text,
                question_id,
                is_correct_answer
            )
            VALUES(
				local_answer_id,
                _answer_text_2,
                local_question_id,
                _answer_is_correct_2
            );
            
             SET local_answer_id = local_answer_id + 1;
        END IF;
        
        IF ISNULL(_answer_text_3) = 0 THEN
			INSERT INTO answers (
				answer_id,
                answer_text,
                question_id,
                is_correct_answer
            )
            VALUES(
				local_answer_id,
                _answer_text_3,
                local_question_id,
                _answer_is_correct_3
            );
            
             SET local_answer_id = local_answer_id + 1;
        END IF;
        
        IF ISNULL(_answer_text_4) = 0 THEN
			INSERT INTO answers (
				answer_id,
                answer_text,
                question_id,
                is_correct_answer
            )
            VALUES(
				local_answer_id,
                _answer_text_4,
                local_question_id,
                _answer_is_correct_4
            );
        END IF;
	ELSE
		UPDATE questions
        SET question_text = IFNULL(_question_text, question_text)
        WHERE question_id = local_question_id;
        
        IF ISNULL(_answer_id_1) = 0 THEN
			UPDATE answers
			SET 
				answer_text = IFNULL(_answer_text_1, answer_text),
                is_correct_answer = IFNULL(_answer_is_correct_1, is_correct_answer)
			WHERE answer_id = _answer_id_1;
        END IF;
        
        IF ISNULL(_answer_id_2) = 0 THEN
			UPDATE answers
			SET 
				answer_text = IFNULL(_answer_text_2, answer_text),
                is_correct_answer = IFNULL(_answer_is_correct_2, is_correct_answer)
			WHERE answer_id = _answer_id_2;
        END IF;
        
        IF ISNULL(_answer_id_3) = 0 THEN
			UPDATE answers
			SET 
				answer_text = IFNULL(_answer_text_3, answer_text),
                is_correct_answer = IFNULL(_answer_is_correct_3, is_correct_answer)
			WHERE answer_id = _answer_id_3;
        END IF;
        
        IF ISNULL(_answer_id_4) = 0 THEN
			UPDATE answers
			SET 
				answer_text = IFNULL(_answer_text_4, answer_text),
                is_correct_answer = IFNULL(_answer_is_correct_4, is_correct_answer)
			WHERE answer_id = _answer_id_4;
        END IF;
    END IF;
    
    SET _return_value = 0;
END$

DELIMITER ;