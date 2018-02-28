CREATE DATABASE IF NOT EXISTS db_team2;

USE db_team2;

CREATE TABLE IF NOT EXISTS users (
    guid VARCHAR(36) NOT NULL PRIMARY KEY,
    email VARCHAR(250) NOT NULL UNIQUE,
    password_hashed VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    school_name VARCHAR(200) NOT NULL,
	graduation_year CHAR(4) NULL,
    secret_question_1 VARCHAR(200) NOT NULL,
    secret_answer_1 VARCHAR(50) NOT NULL,
    secret_question_2 VARCHAR(200) NOT NULL,
    secret_answer_2 VARCHAR(50) NOT NULL,
    access_level INT NOT NULL DEFAULT 0,
    is_active BIT NOT NULL DEFAULT 1,
    created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS security_questions (
	secret_question VARCHAR(500) NOT NULL PRIMARY KEY
);

INSERT IGNORE INTO security_questions (secret_question) VALUES
('What was the name of your elementary / primary school?'),
('In what city or town does your nearest sibling live?'),
('What is your pet’s name?'),
('In what year was your father born?'),
('What was the make and model of your first car?');


CREATE TABLE IF NOT EXISTS schools (
	school_name VARCHAR(200) NOT NULL PRIMARY KEY
);

INSERT IGNORE INTO schools (school_name) VALUES
('Albert I Prince Technical High School'),
('Albertus Magnus College'),
('American Institute-West Hartford'),
('Asnuntuck Community College'),
('Branford Hall Career Institute-Branford Campus'),
('Branford Hall Career Institute-Southington Campus'),
('Branford Hall Career Institute-Windsor Campus'),
('Bridgeport Hospital School of db_team2'),
('Bristol Technical Education Center'),
('Bullard-Havens Technical High School'),
('Capital Community College'),
('Central Connecticut State University'),
('Charter Oak State College'),
('Connecticut College'),
('Eastern Connecticut State University'),
('Eli Whitney Technical High School'),
('Fairfield University'),
('Gateway Community College'),
('Goodwin College'),
('Harris School of Business-Danbury'),
('Hartford Seminary'),
('Holy Apostles College and Seminary'),
('Housatonic Community College'),
('Lincoln College of New England-Southington'),
('Lincoln Technical Institute-East Windsor'),
('Lincoln Technical Institute-New Britain'),
('Lincoln Technical Institute-Shelton'),
('Manchester Community College'),
('Middlesex Community College'),
('Mitchell College'),
('Naugatuck Valley Community College'),
('Northwestern Connecticut Community College'),
('Norwalk Community College'),
('Norwich Technical High School/Adult Licensed Practical Nurse Program'),
('Platt Technical High School'),
('Porter and Chester Institute of Branford'),
('Porter and Chester Institute of Enfield'),
('Porter and Chester Institute of Rocky Hill'),
('Porter and Chester Institute of Stratford'),
('Porter and Chester Institute of Watertown'),
('Post University'),
('Quinebaug Valley Community College'),
('Quinnipiac University'),
('Rensselaer at Hartford'),
('Ridley-Lowell Business & Technical Institute-Danbury'),
('Ridley-Lowell Business & Technical Institute-New London'),
('Sacred Heart University'),
('Southern Connecticut State University'),
('St Vincent''s College'),
('Stone Academy-East Hartford'),
('Stone Academy-Waterbury'),
('Stone Academy-West Haven'),
('Three Rivers Community College'),
('Trinity College'),
('Tunxis Community College'),
('University of Bridgeport'),
('University of Connecticut'),
('University of Connecticut-Avery Point'),
('University of Connecticut-Stamford'),
('University of Connecticut-Waterbury Campus'),
('University of Hartford'),
('University of New Haven'),
('University of Phoenix-Connecticut'),
('University of Saint Joseph'),
('Vinal Technical High School'),
('W F Kaynor Technical High School'),
('Wesleyan University'),
('Western Connecticut State University'),
('Windham Technical High School'),
('Yale University'),
('Yale-New Haven Hospital Dietetic Internship');

CREATE TABLE IF NOT EXISTS trainings (
    training_id INT NOT NULL PRIMARY KEY,
    training_description VARCHAR(250) NOT NULL,
    material LONGBLOB NULL,
    full_path_to_material VARCHAR(250) NOT NULL
);

CREATE TABLE IF NOT EXISTS exams (
	exam_id INT NOT NULL PRIMARY KEY,
    exam_description VARCHAR(250) NOT NULL,
    training_id INT NOT NULL,
    FOREIGN KEY (training_id) REFERENCES trainings(training_id)
);

CREATE TABLE IF NOT EXISTS questions (
	question_id INT NOT NULL PRIMARY KEY,
    question_text TEXT NOT NULL,
    exam_id INT NOT NULL,
	FOREIGN KEY (exam_id) REFERENCES exams(exam_id)
);

CREATE TABLE IF NOT EXISTS answers (
	answer_id INT NOT NULL PRIMARY KEY,
    answer_text TEXT NOT NULL,
    question_id INT NOT NULL,
    is_correct_answer BIT NOT NULL,
	FOREIGN KEY (question_id) REFERENCES questions(question_id)
);

CREATE TABLE IF NOT EXISTS results_summary (
    result_id INT NOT NULL PRIMARY KEY,
    guid VARCHAR(36) NOT NULL,
    started DATETIME NOT NULL,
    exam_id INT NOT NULL,
    total_available_correct_answers INT NOT NULL,
    total_available_correct_answers_seen INT NOT NULL DEFAULT 0,
    total_available_correct_answers_seen_chosen INT NOT NULL DEFAULT 0,
	FOREIGN KEY (guid) REFERENCES users(guid),
	FOREIGN KEY (exam_id) REFERENCES exams(exam_id)
);

CREATE TABLE IF NOT EXISTS results_detailed (
    result_id INT NOT NULL,
    answer_id INT NOT NULL,
    PRIMARY KEY (
		result_id,
        answer_id
    ),
	FOREIGN KEY (result_id) REFERENCES results_summary(result_id),
	FOREIGN KEY (answer_id) REFERENCES answers(answer_id)
);

#Example training with exam with question and answers
insert ignore into trainings values(1,'USA States',null,'');
insert ignore into exams values(1,'USA States',1);
insert ignore into questions values(1,'Which is the largest state by area in USA?',1);
insert ignore into answers values
(1,'Alaska',1,1),
(2,'Texas',1,0),
(3,'California',1,0);
