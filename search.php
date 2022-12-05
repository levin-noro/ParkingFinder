<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
session_start();
if (!isset($_SESSION['isLoggedIn'])) {
	header("Location: https://noronl.comp4ww3.com/login.php");
	exit(); 
}
?>

<?php 
$title = 'Search';
include("head.inc.php") 
?>
<body>
    <!-- Navigation Bar -->
    <?php 
	$active = 'search';
	include("navbar.inc.php");
	?>

    <!-- Page Content -->
    <br>
    <div class="content">
		<h1>Parking Near Me</h1>
		<hr>
		<div class="search" role="search">

			<!-- Search Form -->
			<form method="post" action="results.php" class="search-form" onsubmit="return validateSearch(this);">
	    		<p>
	    			<!-- Search bar -->
		    		<input id="search-bar" name="searchString" type="text" name="location" class="long-textbox" placeholder="Search by address, postal code, or geo coordinates" required>
		    		<button type="submit" name="search" class="search_button"><i class="fa fa-search"></i></button>
		    	</p>
		    	<p>
		    		<!-- Get user's geolocation to place in search bar above -->
		    		<button onclick="getLocation()" type="button" class="custom-button">Use my location instead</button>
		    		<!-- Added a unicode down symbol to each default select option because default arrows don't appear when using 
		    			Chrome Developer Mode's Responsive Design Mode-->
			    	<!-- Filter by distance  -->
			    	<select class="custom-select">
			    		<option value="-1">any distance &#9660;</option>
						<option value="0.5">within 500m</option>
						<option value="1">within 1km</option>
						<option value="2.5">within 2.5km</option>
						<option value="5">within 5km</option>
						<option value="10">within 10km</option>
						<option value="20">within 20km</option>
						<option value="40">within 40km</option>
						<option value="80">within 80km</option>
						<option value="160">within 160km</option>
					</select>
					<!-- Filter by ratings -->
					<select name=minRating class="custom-select">
						<option value="-1">All Ratings &#9660;</option>
						<option value="5">5 star rating</option>
						<option value="4">more than 4</option>
						<option value="3">more than 3</option>
						<option value="2">more than 2</option>
						<option value="1">more than 1</option>
					</select>
					<!-- Filter by price -->
					<select name="maxPrice" class="custom-select">
						<option value="-1">Any Price &#9660;</option>
						<option value="10">$0-$10</option>
						<option value="25">$10-$25</option>
						<option value="50">$25-$50</option>
						<option value="100">$50-$100</option>
						<option value="101">$100+</option>
					</select>
				</p>				
		    </form>

	    </div>
    </div>

    <!-- Footer -->
    <?php 
    include("footer.inc.php") 
    ?>
</body>
</html>