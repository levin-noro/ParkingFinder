<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
include('server.php') 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <link rel="shortcut icon" href="images/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="images/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script src="scripts/myScript.js"></script>
    <script async defer
	  src="https://maps.googleapis.com/maps/api/js?key=apiKey=initMap">
	</script>
</head>
<body>

    <!-- Navigation Bar -->
    <?php 
    $active='';
	include("navbar.inc.php"); 
	?>

	<!-- Page Content -->
    <br>
    <div class="content" role="main">
		<h1>Search Results</h1>
		<hr>
		<!-- Split results into two columns - text form results and map -->
		<!-- Search results are tabulated data and therefore displayed as a table -->
		<div class="results-container">
			<!-- list of results in text form -->
			<div class="list-column">
	    		<table class="results-table">
	    			<!-- Currently the body of results is hardcoded -->
	    			<tbody class="results-body">
		    			<?php
		    			try {
			    			$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'username', 'password');
							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

							// create and execute a query that returns all parking spots that match the search string
							$searchString = '%' . $_SESSION['searchString'] . '%';
							$statement = $pdo->prepare("SELECT id,name,latitude,longitude,description,rate FROM parkings WHERE name LIKE :searchString");
							$statement->bindValue(':searchString',$searchString);

							// put query results into an array
							$parkings = array();
							if ($statement->execute()) {
								while ($parkingRow = $statement->fetch(PDO::FETCH_ASSOC)) {
							        $parkings[] = $parkingRow;
							    }
							}

							// iterate over array of results
							foreach ($parkings as $parking) {
								// Create tabular entry for each parking spot in result
								echo "<tr class=\"search-result-item\">\n";
		    					echo "<td class=\"result\">\n";
		    					$id = 0;
		    					$latitude = 0;
		    					$longitude = 0;
		    					$name = "";
								foreach ($parking as $key => $value) {
									switch ($key) {
										case 'id':
											$id = $value;
											break;
										case 'name':
											$name = $value;
											// echo "<h3><a href=\"parking.php?id=$id\">$value</a></h3>\n";
											break;
										case 'latitude':
											$latitude = $value;
											// echo "Latitude: $value<br>\n";
											break;
										case 'longitude':
											$longitude = $value;
											// echo "Longitude: $value<br>\n";
											break;
										default:
											# code...
											break;
									}
								}
								echo "<h3><a href=\"parking.php?id=$id&latitude=$latitude&longitude=$longitude\">$name</a></h3>\n";
								echo "Latitude: $latitude<br>\n";
								echo "Longitude: $longitude<br>\n";
								echo '</td>';
								echo '</tr>';
							}
						} catch (Exception $e) { 
							print("<script>console.log(\"{$e->getMessage()}\")</script>");
						}
						?>
    				</tbody>
	    		</table>
	    	</div>
	    	<!-- MAP -->
	    	<div class="map-column">
	    		<div id="results-map"></div>
	    	</div>
		</div>
	</div>

    <!-- Footer -->
    <?php 
    include("footer.inc.php") 
    ?>

</body>
</html>