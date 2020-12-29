<?php
	$dsn = 'mysql:host=localhost;dbname=healthcare';
	$username = 'root';
	$password = '';
	$db = new PDO($dsn, $username, $password);

	try {
		$db = new PDO($dsn, $username, $password);
	}
	catch (PDOException $e) {
		$error_message = $e->getMessage();
		echo 'Error connecting to database : $error_message';
	}

	class db2 {
		//PDO object to connect to database
		private static function connect() {
			$pdo = 
			new PDO('mysql:host=localhost;dbname=healthcare_doctors;charset=utf8', 'root', '');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		
		//function to save myself a lot of typing
		public static function query($query, $params = array()) {
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			
			//if the first word in our statement is SELECT run these
			if(explode(' ', $query)[0] == 'SELECT') {
				$data = $statement->fetchAll();
				return $data;
			}
		}
	}

	class db3 {
		//PDO object to connect to database
		private static function connect() {
			$pdo = new PDO('mysql:host=localhost;dbname=healthcare;charset=utf8', 'root', '');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		
		//function to save myself a lot of typing
		public static function query($query, $params = array()) {
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			
			//if the first word in our statement is SELECT run these
			if(explode(' ', $query)[0] == 'SELECT') {
				$data = $statement->fetchAll();
				return $data;
			}
		}
	}
?>
