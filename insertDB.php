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
	$picture = $_POST['picture'];
	$sql = "INSERT INTO pictures (IMAGE) VALUES ('$picture')";
	if ($conn->query($sql) === TRUE) {
		echo "haz been created";
	} else {
		echo "haz error" . $conn->error;
	}

	$conn->close();
 ?>
