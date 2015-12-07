<?php
$files = glob("pictures/*");
if ($files != 0) {
foreach ($files as $file) {
	if (is_file($file)) {
		unlink($file);
	}
}
}
 ?>
