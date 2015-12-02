<?php
	$servername = "localhost";
	$username = "php";
	$password = "123456";
	$dbName = "php";
	$conn = new mysqli($servername,$username,$password,$dbName);
	$sql = "SELECT * FROM pictures";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo $row["IMAGE"];
    };
	} else {
		echo "0 results";
	}

	$conn->close();
 ?>
