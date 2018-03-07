USE db_team2;

INSERT IGNORE INTO trainings (training_id, training_description, material, full_path_to_material) VALUES
(1,'Module 1',NULL,'This is URL to embed module 1 content.'),
(2,'Module 2',NULL,'This is URL to embed module 2 content.'),
(3,'Module 3',NULL,'This is URL to embed module 3 content.');

INSERT IGNORE INTO exams (exam_id, exam_description, training_id, is_active) VALUES
(1,'Exam 1',1,0), # This exam isn't active
(2,'Exam 2',2,1),
(3,'Exam 3',3,1),
(4,'New Exam 1',1,1); # This exam is active

INSERT IGNORE INTO questions (question_id, question_text, exam_id) VALUES
(1,'Question 1 for Exam 1?',1), # This exam isn't active
(2,'Question 2 for Exam 1?',1), # This exam isn't active
(3,'Question 1 for Exam 2?',2), 
(4,'Question 2 for Exam 2?',2), 
(5,'Question 1 for Exam 3?',3), 
(6,'Question 2 for Exam 3?',3), 
(7,'Question 3 for Exam 3?',3), 
(8,'Question 1 for New Exam 1?',4);

INSERT IGNORE INTO answers (answer_id, answer_text, question_id, is_correct_answer) VALUES
(1,'True',1,1), # This exam isn't active
(2,'False',1,0), # This exam isn't active
(3,'a',2,0), # This exam isn't active
(4,'b',2,1), # This exam isn't active
(5,'c',2,1), # This exam isn't active
(6,'a',3,0), # This question has two correct answers
(7,'b',3,1), # This question has two correct answers
(8,'c',3,1), # This question has two correct answers
(9,'d',3,0), # This question has two correct answers
(10,'a',4,0), # This question has one correct answer
(11,'b',4,0), # This question has one correct answer
(12,'c',4,1), # This question has one correct answer
(13,'d',4,0), # This question has one correct answer
(14,'a',5,1), # This question has three correct answers
(15,'b',5,0), # This question has three correct answers
(16,'c',5,1), # This question has three correct answers
(17,'d',5,1), # This question has three correct answers
(18,'a',6,0), # This question has one correct answer
(19,'b',6,0), # This question has one correct answer
(20,'c',6,1), # This question has one correct answer
(21,'d',6,0), # This question has one correct answer
(22,'a',7,0), # This question has one correct answer
(23,'b',7,0), # This question has one correct answer
(24,'c',7,1), # This question has one correct answer
(25,'d',7,0), # This question has one correct answer
(26,'a',8,1), # This question has one correct answer
(27,'b',8,0); # This question has one correct answer
