<?php graphData(); ?>
<?php
function graphData() {
	error_reporting(E_ERROR | E_PARSE);
	$conn = mysqli_connect('localhost', 'user', 'password');
	if (!$conn) {
	    die('Conn error.');
	}
	$selected_database = mysqli_select_db($conn, "canvasjs_db");
	if (!$selected_database) {
	    die('Died.');
	}
	$query = "select max(reading) as max_reading from (select * from tblReadings ORDER by 1 desc LIMIT 5) as stuff";
	$data = mysqli_query($conn, $query);
	$results = "";
	while ($row = mysqli_fetch_array($data, MYSQL_ASSOC)) {
	        $results = $row['max_reading'];
	}
	echo $results;
	mysqli_close($conn);
}
?>
