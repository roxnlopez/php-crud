<?php

require('../connection.php');

Class Car {

	static public function find() {

		global $mysql_connection;

    if($mysql_connection->connect_error){
        $mysql_connection->close();
        die('Connection Failed: ' . $mysql_connection->connect_error);
    } else {
        $sql = "SELECT * FROM cars;";
        $results = $mysql_connection->query($sql);
        return $results;
    }			
	}

	static public function create($car, $owner) {

		global $mysql_connection;

		if($mysql_connection->connect_error) {
			die('Connection failed: ' . $mysql_connection->connect_error);
		} else {
			$sql = "INSERT INTO cars (car, owner) VALUES ('".$car."','".$owner."');";
			$mysql_connection->query($sql);
		}
	}	

	static public function delete($id) {

		global $mysql_connection;

		if($mysql_connection->connect_error) {
			die('Connection failed: ' . $mysql_connection->connect_error);
		} else {
			$sql = "DELETE FROM cars
WHERE id=".$id.";";
			$mysql_connection->query($sql);
		}
	}	

}

?>