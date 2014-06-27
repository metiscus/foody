<?php
	$mysqli = new mysqli("localhost", "telemetry", "35b3rVF2Gl", "foody_telemetry");
	//$result = $mysqli->query("SELECT 'Hello, dear MySQL user!' AS _message FROM DUAL");
	//$row = $result->fetch_assoc();
	//echo htmlentities($row['_message']);

	$url_elements = explode('/', $_SERVER['REQUEST_URI']);
	print_r( $url_elements );
?>
