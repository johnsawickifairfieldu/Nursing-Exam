<?php


//Attempt to connect to MySQL database
$connection =  new PDO("mysql:host=localhost;dbname=nursing", 'bindu', 'password');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>