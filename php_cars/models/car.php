<?php
	Class Car {
		static public function find() {
			$servername = 'localhost';
			$username = 'root';
			$password = 'root';
			$dbname = 'phpcrud';
		}
		$mysql_connection = new mysqli($servername, $username, $password, $dbname);
	}
?>