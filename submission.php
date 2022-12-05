<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

session_start();
if (!isset($_SESSION['isLoggedIn'])) {
    header("Location: https://noronl.comp4ww3.com/login.php");
    exit(); 
}

include('server.php') 
?>

<?php 
$title = 'Submit My Parking Spot';
include("head.inc.php") 
?>
<body>
    <!-- Navigation Bar -->
    <?php 
    $active = 'submission';
    include("navbar.inc.php");
    ?>

    <!-- Page Content -->
    <br>
    <div class="content" role="form">

    	<!-- Parking Submission Form -->
		<h1>Submit My Parking Spot</h1>
		<hr>
		<form method="post" action="submission.php" onsubmit="return validateSubmissionForm(this);">
			<!-- All text fields are required -->
			<p>
	    		Name of Parking Spot:<br>
	    		<input type="text" name="parkingName" placeholder="Enter a name for your parking spot" class="long-textbox" id="parkingName" maxlength="50" required>
	    	</p>
	    	<p>
	    		Parking Spot Description:<br>
	    		<textarea name="description" cols="40" rows="3" class="custom-textarea" id="description" maxlength="500"></textarea required>
	    	</p>
	    	<p>
	    		Latitude Coordinate<br>
	    		<input type="text" id="latitude" name="latitude" placeholder="Enter latitude coordinate of your parking spot." class="long-textbox" required>
	    	</p>
	    	<p>
	    		Longitude Coordinate<br>
	    		<input type="text" id="longitude" name="longitude" placeholder="Enter longitude coordinate of your parking spot." class="long-textbox" required>
	    	</p>
            <p>
                Parking Rate<br>
                <input type="text" id="rate" name="rate" placeholder="Enter parking rate." class="long-textbox" maxlength="7" required>
            </p>
	    	<!-- Fetch user's geolocation and paste it into the text boxes above -->
	    	<button onclick="getLocationForSubmission()" type="button" class="custom-button">Use my location instead</button>
	    	<p>
	    		Upload a picture of the parking spot<br> <input type="file" name="image">
	    	</p>
	    	<p>
	    		<input type="submit" name="submission" class="register_login_button">
	    	</p>
		</form>
	</div>

    <!-- Footer -->
    <?php 
    include("footer.inc.php") 
    ?>
</body>
</html>