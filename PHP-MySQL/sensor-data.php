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
	$query = "select concat('[', id, ', ', reading, '],' ) as datar from (select id, reading from tblReadings ORDER by id desc LIMIT 20) as stuff order by 1";
	// $query = "select concat('[', x, ', ', y, '],' ) as datar from datapoints";
	$data = mysqli_query($conn, $query);
	$results = "";
	$dataPoints = array();
	while ($row = mysqli_fetch_array($data, MYSQL_ASSOC)) {
	    array_push($dataPoints, $row);
	        $results .= $row['datar'] . "\r\n";
	}
	// remove last comma
	$results = substr($results, 0, strlen($results) - 3);
	echo $results;
	mysqli_close($conn);
}
?>
