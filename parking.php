<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
session_start();
include('server.php') 
?>

<!-- Not placed in an include php file because of the massive Google Maps function that is defined in the header -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="twitter:card" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
	<meta name="twitter:site" content="@parkingfinder" />
	<meta name="twitter:creator" content="@Bob" />
    <meta property="og:title" content="Parking Spot #1" />
    <meta property="og:type" content="html" />
    <meta property="og:image" content="images/parking_spot.jpg" />
    <meta property="og:url" content="parking.html" />
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
	<link rel="manifest" href="images/site.webmanifest">
	<link rel="shortcut icon" href="images/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="images/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
    <title>Parking Spot #1</title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="scripts/myScript.js"></script>
    <script type="text/javascript">
    	// use Google Maps API to show location of individual parking spot
		function initMapParking() {
			<?php 
				echo "var latitude = Number({$_GET['latitude']});";
				echo "var longitude = Number({$_GET['longitude']});";
			?>
			// insert Google Maps into an existing empty map div
			var map = new google.maps.Map(document.getElementById('map'), {
			  center: {lat: latitude, lng:longitude},
			  zoom: 19, // set zoom so that buildings and driveways are clearly visible
			  mapTypeId: 'satellite'
			});	

			/* PARKING MARKER LABEL CONTENT*/
			var contentString1 = 
		      '<h1 id="parkingHeading" class="parkingHeading">Parking Spot #1</h1>'+
		      '<div id="parkingBodyContent">'+
		      '<p><b>571 Urban Dr, Hamilton, ON</b><br>'+
		      'Rate: $10/hour<br>'+
		      'Overall Rating: 4.5/5</p>'+
		      '</div>'+
		      '</div>';

		    /* PARKING MARKER LABEL*/
		    var infowindow1 = new google.maps.InfoWindow({
		    content: contentString1
		  	});

		    /* PARKING MARKER*/
			var marker1 = new google.maps.Marker({
		    position: {lat: latitude, lng: longitude},
		    map: map,
		    title: 'Hello World!'
		  	});

			// display information label on click
		  	marker1.addListener('click', function() {
		    infowindow1.open(map, marker1);
		  	});
		}
    </script>
    <script async defer
	  src="https://maps.googleapis.com/maps/api/js?key=apiKey&callback=initMapParking">
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
    <div itemscope class="content" role="main">
		<?php 
			
			$_SESSION['parking_id'] = $_GET['id']; //store the current parking id in the session so that it can be used later to retrieve reviews
			$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// retrieve all information about this parking spot
			$statement = $pdo->prepare('SELECT * FROM parkings WHERE id=:id');
			$statement->bindValue(':id',$_GET['id']);
			$statement->execute();
			// store information in PHP variables to use later
			$parkingRow = $statement->fetch(PDO::FETCH_ASSOC);
			$name = $parkingRow['name'];
			$owner_id = $parkingRow['owner_id'];
			$latitude = $parkingRow['latitude'];
			$longitude = $parkingRow['longitude'];
			$description = $parkingRow['description'];
			$rate = $parkingRow['rate'];

			// retrieve the user's full name
			$statement = $pdo->prepare('SELECT fname,lname FROM users WHERE id=:id');
			$statement->bindValue(':id',$owner_id);
			if ($statement->execute()) {
				$ownerRow = $statement->fetch(PDO::FETCH_ASSOC);
			    $fname = $ownerRow['fname'];
			    $lname = $ownerRow['lname'];
			}

			echo "<h1 itemprop=\"itemreviewed\">$name</h1>";
			echo "<hr>";
			echo "<div id=\"map\"></div>";

			// Create description of parking
			echo "<p><strong>Owner:</strong> <span>$fname $lname</span></p>\n";
			echo "<p><strong>Latitude:</strong> <span>$latitude</span></p>\n";
			echo "<p><strong>Longitude:</strong> <span>$longitude</span></p>\n";
			echo "<p><strong>Description:</strong> <span>$description</span></p>\n";
			echo "<p><strong>Rate:</strong> <span>\$$rate</span></p>\n";
		?>
		<hr>
		<h3>Ratings & Reviews</h3>

		<!-- Table of Reviews -->
		<!-- Reviews are shown in a table because they are tabulated data which will be fetched from a database  -->
		<table itemscope class="reviews-table">
			<!-- Currently, the reviews are hardcoed. In later assignments, they will likely be fetched from a database and displayed here -->
			<tbody class="reviews-table-body">
				<?php
					$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					// retrieve all reviews for this parking spot
					$statement = $pdo->prepare("SELECT * FROM reviews WHERE parking_id=:parking_id");
					echo "<script>console.log(\"{$_GET['id']}\")</script>";
					$statement->bindValue(':parking_id',$_GET['id']);

					// put query results into an array
					$reviews = array();
					if ($statement->execute()) {
						while ($reviewRow = $statement->fetch(PDO::FETCH_ASSOC)) {
					        $reviews[] = $reviewRow;
					    }
					}

					// iterate over array of results
					foreach ($reviews as $review) {
						// create HTML for each review
						echo "<tr class=\"review\">\n";
						echo "<td class=\"reviews-username-column\">\n";
						// retrieve reviewer's full name from users table
						$statement = $pdo->prepare('SELECT fname,lname FROM users WHERE id=:id');
						$statement->bindValue(':id',$review['reviewer_id']);
						if ($statement->execute()) {
							$ownerRow = $statement->fetch(PDO::FETCH_ASSOC);
						    $fname = $ownerRow['fname'];
						    $lname = $ownerRow['lname'];
						}
						echo "<strong itemprop=\"reviewer\">$fname $lname</strong><br>";
						$rating = $review['rating'];
						echo "<span itemprop=\"rating\">$rating/5</span><br><br>";
						echo "</td>";
						$description = $review['review'];
						echo "<td itemprop=\"description\" class=\"reviews-review-column\">";
						echo "$description";
						echo "</td>\n";
						echo "</tr>\n";
					}
				?>
			</tbody>
		</table>

		<hr>
		<!-- Registration Form -->
		<form class="reviewForm" method="post" action="<?php echo "parking.php?id={$_GET['id']}" ?>" onsubmit="return validateRegistrationForm(this);">
			<!-- All text, email, and password fields are required -->
			<h4>Submit Your Review</h4>
	    	<p>
	    		Parking Rating: 
				<select name="rating">
					<option value="1">1 Star</option>
					<option value="2">2 Star</option>
					<option value="3">3 Star</option>
					<option value="4">4 Star</option>
					<option value="5">5 Star</option>
				</select>
	    	</p>
			<p>
	    		Parking Review:<br>
	    		<textarea name="review" cols="40" rows="3" class="review-textarea" id="review" maxlength="500"></textarea required>
	    	</p>
	    	<p>
	    		<button type="submit" name="submit_review" class="submit_review_button">Submit</button>
	    	</p>
	    </form>

	</div>

    <!-- Footer -->
    <?php 
    include("footer.inc.php") 
    ?>
</body>
</html>