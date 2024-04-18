<?php

/* Add your functions here */

include 'config/config.php';
function dbConnect(){
    /* defined in config/config.php */
    /*** connection credentials *******/
    $servername = SERVER;
    $username = USERNAME;
    $password = PASSWORD;
    $database = DATABASE;
    $dbport = PORT;
    /****** connect to database **************/

    try {
        $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4;port=$dbport", $username, $password);
	return $db;
    }
    catch(PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}

/* query with no SQL arguments */
function getNeighborhoods($db) {
    try {
        $stmt = $db->prepare("select * from neighborhoods order by neighborhood asc") ;
        $stmt->execute() ;
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ;
        return $rows ;
    } catch (Exception $e) {
        echo $e ;
    }
}

?>
