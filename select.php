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

		fwrite($ifp, base64_decode($base64_string));

		fclose($ifp);

		return $output_file;
	}
	$files = glob("pictures/*");
	if ($files != 0) {
	foreach ($files as $file) {
		if (is_file($file)) {
			unlink($file);
		}
	}
}
	if ($result->num_rows > 0) {
		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$string = preg_replace('/data:image\/jpeg;base64,/', "",$row["IMAGE"]);
			// $string = preg_replace('/[[:blank:]]/', "",$string);
			// $string = preg_replace('/[\/]/', "",$string);
			// print_r($string);
			base64_to_jpeg($string, "pictures/$i.jpeg");
			echo '<div class="grid-item"><img src="'. "pictures/$i.jpeg" .'"></div>';

			$i = $i + 1;
    };
	} else {
		echo "0 results";
	}

	$conn->close();
 ?>
<img src="" alt="" />
