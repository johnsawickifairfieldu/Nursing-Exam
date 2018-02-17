<?php
/* Database credentials. Assuming you are running MySQL
server with user 'root' with password 'test1234' */
define('DB_SERVER', 'localhost');
define('DB_NAME', 'nursing');
 
//Attempt to connect to MySQL database
$connection = mysqli_connect(DB_SERVER, 'root', 'test1234', DB_NAME);
 
//Check connection
if($connection === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>