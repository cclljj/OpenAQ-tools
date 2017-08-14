<html>
<head>
<title>OpenAQ status report</title>

<!-- the sorttable.js library is provided by https://www.kryogenix.org/code/browser/sorttable/ -->
<script src="sorttable.js"></script>
<style type="text/css">
th, td {
  padding: 3px !important;
}

/* Sortable tables */
table.sortable thead {
    background-color: #333;
    color: #cccccc;
    /* font-weight: bold; */
    cursor: default;
}
</style>
</head>
<body>

<?php


function mysort($a, $b)
{
    return strcmp($a['sourceName'], $b['sourceName']);
}

$string = "./OpenAQ.json";
$string = file_get_contents($string);
$data = json_decode($string, true);
?>
<h2>OpenAQ Status Report</h2>
<font size="+1">
<b>Number of records</b>: <?php echo $data["num_of_records"]; ?>
<br>
<b>Last update (UTC time)</b>: <?php echo $data["version"]; ?>
<br>
</font>
<table border=1 class="sortable">
<th>
<!--<td >No.</td> -->
<td >Status</td>
<td >Source</td>
<td >Country</td>
<td >City</td>
<td >Location</td>
<td >PM2.5</td>
<td >PM10</td>
<td >CO</td>
<td >O3</td>
<td >NO2</td>
<td >SO2</td>
<td >BC</td>
<td >GPS</td>
<td >Last seen</td>
</th>

<?php
$feeds = $data["feeds"];
$i = 1;
usort($feeds, mysort);

foreach ($feeds as $item){
  if ($item["active"]==-1){
    echo "<tr bgcolor=\"d0d0d0\">";
  } else {
    echo "<tr>";
  }

?>


<td><?php echo $i; ?></td>
<td>
<?php 
  	if ($item["active"]==-1){
    		echo "<img src=\"image/offline.png\" alt=\"offline\" width=25>";
  	} else {
    		echo "<img src=\"image/online.png\" alt=\"online\" width=25>";
 	}
?>
</td>
<td><?php echo $item["sourceName"]; ?></td>
<td><?php echo $item["country"]; ?></td>
<td><?php echo $item["city"]; ?></td>
<td><?php echo $item["location"]; ?></td>
<td>
<?php
	$sensor = "pm25";
	if ($item["sensor"][$sensor]<0) { echo "N/A"; } else { echo $item["sensor"][$sensor]; }
?>
</td>
<td>
<?php
	$sensor = "pm10";
	if ($item["sensor"][$sensor]<0) { echo "N/A"; } else { echo $item["sensor"][$sensor]; }
?>
</td>
<td>
<?php
	$sensor = "co";
	if ($item["sensor"][$sensor]<0) { echo "N/A"; } else { echo $item["sensor"][$sensor]; }
?>
</td>
<td>
<?php
	$sensor = "o3";
	if ($item["sensor"][$sensor]<0) { echo "N/A"; } else { echo $item["sensor"][$sensor]; }
?>
</td>
<td>
<?php
	$sensor = "no2";
	if ($item["sensor"][$sensor]<0) { echo "N/A"; } else { echo $item["sensor"][$sensor]; }
?>
</td>
<td>
<?php
	$sensor = "so2";
	if ($item["sensor"][$sensor]<0) { echo "N/A"; } else { echo $item["sensor"][$sensor]; }
?>
</td>
<td>
<?php
	$sensor = "bc";
	if ($item["sensor"][$sensor]<0) { echo "N/A"; } else { echo $item["sensor"][$sensor]; }
?>
</td>
<td>
        <?php echo $item["gps_lat"]; ?>, <?php echo $item["gps_lon"]; ?>
</td>
<td>
	<?php echo $item["timestamp"]; ?>
</td>
</tr>

<?php
	$i++;
}
/*
*/
?>

</table>

</body>
</html>
