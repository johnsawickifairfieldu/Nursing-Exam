<?php
class DB {

  
   function get_connection() {
    try {
    $db = new PDO("mysql:host=localhost;dbname=nursing", 'bindu', 'password');      
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch(PDOException $ex) {
        echo 'An Error occured! '.$ex->getMessage(); //user friendly message    
        error_log('failed to connect to db - Exception caught: '.$ex->getMessage());
        return false;
    }

    return $db;
   }
}
?>