<?php
	
	$servername = "localhost";
	$username = "php";
	$password = "123456";
	$dbName = "php";
	$conn = new mysqli($servername,$username,$password,$dbName);
	$sql = "SELECT * FROM pictures";
	$result = $conn->query($sql);

	function base64_to_jpeg($base64_string, $output_file)
	{
		$ifp = fopen($output_file, "wb");

		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);

		return $output_file;
	}

	if ($result->num_rows > 0) {
		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$string = explode(",",$row["IMAGE"]);

			echo '<div class="grid-items"> <img src="'. base64_decode($string[1]) .'"></div>';
			$i = $i + 1;
    };
	} else {
		echo "0 results";
	}

	$conn->close();
 ?>
