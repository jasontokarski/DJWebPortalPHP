<?php
try{
		$username = 'mysqluser';
		$password = 'mysqlpassword';
		$dsn = 'mysql:host=mysqlhost;dbname=databasename';
		$pdo = new PDO($dsn, $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e){
		echo "Couldnt not connect. Error: " . $e->getMessage();
}
?>
