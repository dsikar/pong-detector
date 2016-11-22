<html>
<head>
  <meta http-equiv="refresh" content="1" />
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Reading');
      data.addColumn('number', 'Methane Level');


      data.addRows([
<?php graphData(); ?>
      ]);

      var options = {
        chart: {
          title: 'IOT Methane Sensor Reading',
          subtitle: 'BROUGHT TO YOU BY (SPONSOR GOES HERE!)'
        },
        width: 1550,
        height: 700,
	lineWidth: 10,
	colors: ['#e2431e'],
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="line_top_x"></div>
</body>
</html>

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
