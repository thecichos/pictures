<?php
	$servername = "localhost";
	$username = "php";
	$password = "123456";
	$dbName = "php";
	$conn = new mysqli($servername,$username,$password,$dbName);
	if ($conn->connect_error) {
		echo "connection failed" . $conn->connect_error;
	}
	echo "you haz success";
	$sql = "CREATE TABLE pictures (
		ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		IMAGE BLOB NOT NULL
	)";
	if ($conn->query($sql) === TRUE) {
		echo "Table created";
	} else {
		echo "you haz error " . $conn->error;
	}
	$conn->close();
 ?>
