<html>

  <head>
    <title>OpenAQ status report</title>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> -->
    
    <!-- <link href="css/bootstrap.css" rel="stylesheet"> 
    <link href="css/all.css" rel="stylesheet"> --> <!--load all styles -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> 

    <!-- Bootstrap 4.5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Bootstrap Table -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    <style type="text/css"> 
      .th-wrap{
        padding:.75rem;vertical-align:bottom;overflow:hidden;text-overflow:ellipsis;white-space:pre-line;} 
    </style>

    <!-- Sorting -->
    <script src="https://cdn.jsdelivr.net/gh/wenzhixin/bootstrap-table-examples@master/utils/natural-sorting/dist/natural-sorting.js"></script>

    <!-- Fixed -->
<!--     <link href="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script> -->

    <!-- Sticky Head-->
  <!--   <link href="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js"></script> -->  

    <style>
      .table .thead-blue th {
        color: #fff;
        background-color: #17a2b8;
        border-color: #ffffff;
        word-wrap:break-word;
      }
      .bootstrap-table .fixed-table-container .table thead th .th-inner{
        text-overflow: ellipsis;
        white-space: pre-line;
      }
    </style>

  </head>

<body>

<?php
$string = "./OpenAQ.json";
$string = file_get_contents($string);
$data = json_decode($string, true);
?>

<div class=container-fluid style="padding:25px"> 
<h2>OpenAQ Status Report</h2>
<font size="+1">
<b>Number of records</b>: <?php print($data["num_of_records"]); ?>
<br>
<b>Last update (UTC time)</b>: <?php print($data["version"]); ?>
<br>
</font>


      <!-- Table -->
      <div class="table-responsive">

        <!-- Toolbar -->
        <!-- <div id="toolbar">
          <button id="button" class="btn btn-secondary">Show Attributes</button>
          <button id="button2" class="btn btn-secondary">Hide Attributes</button>
        </div> -->
        <!-- data-toolbar="#toolbar" -->

        <table id="openaq" class="table table-striped table-bordered" cellspacing="0" 
        data-toggle="table" 
        data-pagination="true" 
	data-page-list="[100, 200, 500, All]" 
        data-search="true"
	data-search-text=""
	data-page-size="100"
	>
        <!-- data-show-fullscreen="true" data-show-pagination-switch="true" data-show-columns="true" -->

          <!-- table header -->
          <thead class="thead-blue" style="text-overflow: ellipsis; white-space: pre-line;">
            <tr>
<th data-sortable="true">No.</th>
<th data-sortable="true" >Source</th>
<th data-sortable="true" >Country</th>
<th data-sortable="true" >City</th>
<th data-sortable="true" >Location</th>
<th data-sortable="true" >PM2.5</th>
<th data-sortable="true" >PM10</th>
<th data-sortable="true" >CO</th>
<th data-sortable="true" >O3</th>
<th data-sortable="true" >NO2</th>
<th data-sortable="true" >SO2</th>
<th data-sortable="true" >BC</th>
<th data-sortable="true">GPS</th>
<th data-sortable="true">Last seen</th>
</tr>
          </thead>
          <!-- table body -->
          <tbody>
<?php
$feeds = $data["feeds"];
$i = 1;
foreach ($feeds as $item){
  if ($item["active"]==-1){
    //echo "<tr bgcolor=\"d0d0d0\">";
  } else {
    //echo "<tr>";
  }
?>

<tr>
<td align="center"><?php print($i); ?></td>
<td>
<?php 
  	if ($item["active"]==-1){
    		print("<img src=\"image/offline.png\" alt=\"offline\" width=25>");
  	} else {
    		print("<img src=\"image/online.png\" alt=\"online\" width=25>");
 	}
	print($item["sourceName"]); 
?>
</td>
<td align="center"><?php 
	if (isset($item["country"])){
		print($item["country"]);
	} else {
		print("N/A");
	}
?></td>
<td align="center"><?php 
	if (isset($item["city"])){
		print($item["city"]);
	} else {
		print("N/A");
	}
?></td>
<td align="center"><?php
	if (isset($item["location"])){
		print($item["location"]);
	} else {
		print("N/A");
	}
?></td>
<td>
<?php
	$sensor = "pm25";
	if ($item["sensor"][$sensor]<0) { print("N/A"); } else { print($item["sensor"][$sensor]); }
?>
</td>
<td>
<?php
	$sensor = "pm10";
	if ($item["sensor"][$sensor]<0) { print("N/A"); } else { print($item["sensor"][$sensor]); }
?>
</td>
<td>
<?php
	$sensor = "co";
	if ($item["sensor"][$sensor]<0) { print("N/A"); } else { print($item["sensor"][$sensor]); }
?>
</td>
<td>
<?php
	$sensor = "o3";
	if ($item["sensor"][$sensor]<0) { print("N/A"); } else { print($item["sensor"][$sensor]); }
?>
</td>
<td>
<?php
	$sensor = "no2";
	if ($item["sensor"][$sensor]<0) { print("N/A"); } else { print($item["sensor"][$sensor]); }
?>
</td>
<td>
<?php
	$sensor = "so2";
	if ($item["sensor"][$sensor]<0) { print("N/A"); } else { print($item["sensor"][$sensor]); }
?>
</td>
<td>
<?php
	$sensor = "bc";
	if ($item["sensor"][$sensor]<0) { print("N/A"); } else { print($item["sensor"][$sensor]); }
?>
</td>
<td>
        <?php print($item["gps_lat"].", ".$item["gps_lon"]); ?>
</td>
<td>
	<?php print($item["timestamp"]); ?>
</td>
</tr>

<?php
	$i++;
}
/*
*/
?>
                      </tbody>
</table>
      <!-- End Table -->

    </div>
    </div>


    <script type="text/javascript"> 
     var $table = $('#openaq')


      $table.bootstrapTable({
        // "height": undefined,
        "search": true,
        // "fixedColumns": true,
        // "fixedNumber": 3,
        "showColumn":true,
        //"showFullscreen": true
      })

    </script>
</body>
</html>
