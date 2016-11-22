<?php

// TODO read db and pword from config file.

$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query);
$reading = $query['analogRead'];

insertData($reading);

function insertData($reading) {
	error_reporting(E_ERROR | E_PARSE);
	$conn = mysqli_connect('localhost', 'user', 'password');
	if (!$conn) {
	    die('Conn error.');
	}
	$selected_database = mysqli_select_db($conn, "canvasjs_db");
	if (!$selected_database) {
	    die('Died.');
	}
	$query = "insert into tblReadings(reading) Values (" . $reading . ")";
	$data = mysqli_query($conn, $query);
	echo $data;
	mysqli_close($conn);
}
?>
