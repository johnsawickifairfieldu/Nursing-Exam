USE db_team2;

insert ignore into trainings values (1 , 'Training Module 1' ,null , 'http://my.visme.co/projects/dmvvdg0k-6ep5dm1gwej75dz3')
ON DUPLICATE KEY UPDATE training_description='Training Module 1', full_path_to_material='http://my.visme.co/projects/dmvvdg0k-6ep5dm1gwej75dz3';

insert ignore into trainings values (2 , 'Training Module 2' ,null, 'https://my.visme.co/projects/kkzxj9jk-18r276j7gn3756qz')
ON DUPLICATE KEY UPDATE training_description='Training Module 2', full_path_to_material='https://my.visme.co/projects/kkzxj9jk-18r276j7gn3756qz';

insert ignore into trainings values (3 , 'HIPAA' ,null , 'https://my.visme.co/projects/01oy4v70-64r50193e6kr2pz1')
ON DUPLICATE KEY UPDATE training_description='HIPAA', full_path_to_material='https://my.visme.co/projects/01oy4v70-64r50193e6kr2pz1';

insert ignore into trainings values (4 , 'Life Safety Management',null,'https://my.visme.co/projects/dmvdewg1-owpln01w84wn5zd6')
ON DUPLICATE KEY UPDATE training_description='Life Safety Management', full_path_to_material='https://my.visme.co/projects/dmvdewg1-owpln01w84wn5zd6';


select * from trainings;

insert into exams (exam_id, exam_description, training_id) values(1 , 'Exam For Training Module 1' , 1);
insert into exams (exam_id, exam_description, training_id) values(2 , 'Exam For Training Module 2' , 2);
insert into exams (exam_id, exam_description, training_id) values(3 , 'Exam For Training Module 3' , 3);

select * from exams;
select q.question_id from questions q join exams e where  e.exam_id = q.exam_id and e.training_id = 1 and e.exam_id = 1;


insert into questions values(1 , 'What does PHP stand for?' , 1);
insert into answers values(1 , 'Hypertext Preprocessor' , 1 , 1);
insert into answers values(2 , 'Pretext Hypertext Processor' , 1 , 0);
insert into answers values(3 , 'Preprocessor Home Page' , 1 , 0);
insert into answers values(4 , 'None Of The Above' , 1 , 0);

insert into questions values(2 , 'PHP files have a default file extension of' , 1);
insert into answers values(5 , '.php' , 2 , 1);
insert into answers values(6 , '.html' , 2 , 0);
insert into answers values(7 , '.xml' , 2 , 0);
insert into answers values(8 , '.ph' , 2 , 0);

insert into questions values(3 , 'PHP is an example of which scripting language?' , 1);
insert into answers values(9 , 'Server-side' , 3 , 1);
insert into answers values(10 , 'Client-side' , 3 , 0);
insert into answers values(11 , 'Browser-side' , 3 , 0);
insert into answers values(12 , 'In-side' , 3 , 0);


insert into questions values(4 , 'Who is the father of PHP?' , 1);
insert into answers values(13 , 'Willam Makepiece' , 4 , 0);
insert into answers values(14 , 'Drek Kolkevi' , 4 , 0);
insert into answers values(15 , 'List Barely' , 4 , 0);
insert into answers values(16 , 'Rasmus Lerdorf' , 4 , 1);

select * from questions;
select * from answers;
select answer_id from answers where question_id = 1;
select a.answer_text,q.question_text from answers a join questions q where a.question_id = q.question_id and q.question_id=1;

insert into questions values(5 , 'A PHP script should start  and end with' , 2);
insert into answers values(17 , '< php >' , 5 , 0);
insert into answers values(18 , '< ?php ?>' , 5 , 1);
insert into answers values(19 , '< ? ? >' , 5 , 0);
insert into answers values(20 , '< ? php ? >' , 5 , 0);

insert into questions values(6 , 'Which of the looping statements is/are supported by PHP?' , 2);
insert into answers values(21 , 'for loop' , 6 , 0);
insert into answers values(22 , 'while loop' , 6 , 0);
insert into answers values(23 , 'do-while loop' , 6 , 0);
insert into answers values(24 , 'All Of The Above' , 6 , 1);

insert into questions values(7 , 'Which of the following is/are a PHP code editor? ditor?' , 2);
insert into answers values(25 , 'Notepad' , 7 , 0);
insert into answers values(26 , 'Notepad++' , 7 , 0);
insert into answers values(27 , 'Adobe Dreamweaver' , 7 , 0);
insert into answers values(28 , 'All Of The Above' , 7 , 1);

insert into questions values(8 , 'Which version of PHP introduced Try/catch Exception?' , 2);
insert into answers values(29 , 'PHP 4' , 8 , 0);
insert into answers values(30 , 'PHP 5' , 8 , 1);
insert into answers values(31 , 'PHP 5.3' , 8 , 0);
insert into answers values(32 , 'PHP 6' , 8 , 0);

select * from questions;
select * from answers;

insert into questions values(9 , 'What cannot be used to comment a single line?' , 3);
insert into answers values(33 , '//' , 9 , 0);
insert into answers values(34 , '#' , 9 , 0);
insert into answers values(35 , '/?' , 9 , 1);
insert into answers values(36 , '/* */' , 9 , 0);

insert into questions values(10 , 'Which of the following php statement/statements will store 111 in variable num?' , 3);
insert into answers values(37 , 'int $num = 111;' , 10 , 0);
insert into answers values(38 , 'int mum = 111;' , 10 , 0);
insert into answers values(39 , '$num = 111;' , 10 , 1);
insert into answers values(40 , '111 = $num;' , 10 , 0);

insert into questions values(11 , 'If $a = 12 what will be returned when ($a == 12) ? 5 : 1 is executed?' , 3);
insert into answers values(41 , '12' , 11 , 0);
insert into answers values(42 , '1' , 11 , 0);
insert into answers values(43 , 'Error' , 11 , 0);
insert into answers values(44 , '5' , 11 , 1);

insert into questions values(12 , 'Which of the following PHP statements will not output Hello World on the screen?' , 3);
insert into answers values(45 , 'echo ("Hello World");' , 12 , 0)
ON DUPLICATE KEY UPDATE answer_text='echo ("Hello World");';
insert into answers values(46 , 'sprintf ("Hello World");' , 12 , 1)
ON DUPLICATE KEY UPDATE answer_text='sprintf ("Hello World");';
insert into answers values(47 , 'printf ("Hello World");' , 12 , 0)
ON DUPLICATE KEY UPDATE answer_text='printf ("Hello World");';
insert into answers values(48 , 'print ("Hello World");' , 12 , 0)
ON DUPLICATE KEY UPDATE answer_text='print ("Hello World");';

select * from questions;
select * from answers;


