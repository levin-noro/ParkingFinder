<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
include('server.php') 
?>

<?php 
$title = 'Registration';
include("head.inc.php");
?>
<body>
    <!-- Navigation Bar -->
    <?php 
	$active = 'register';
	include("navbar.inc.php");
	?>

    <!-- Page Content -->
    <div class="content" role="form">

		<h1>Registration</h1>
		<p>Please fill in the following information to create an account</p>
		<hr>

		<!-- Registration Form -->
		<form method="post" action="registration.php" onsubmit="return validateRegistrationForm(this);">
			<!-- All text, email, and password fields are required -->
	    	<p>
	    		First Name:<br>
	    		<input type="text" name="firstName" placeholder="Enter First Name" id="firstName" maxlength="20" required>
	    	</p>
	    	<p>
	    		Last Name:<br>
	    		<input type="text" name="lastName" placeholder="Enter Last Name" id="lastName" maxlength="20" required>
	    	</p>
	    	<p>
	    		Email:<br>
	    		<input type="email" name="email" placeholder="Enter Email" id="email" maxlength="50" required>
	    	</p>
	    	<p>
	    		Password:<br>
	    		<input type="password" name="password" placeholder="Enter Password" id="password" required>
	    	</p>
	    	<p>
	    		Confirm Password:<br>
	    		<input type="password" name="confirmPassword" placeholder="Re-enter Password" id="confirmPassword" required>
	    	</p>
	    	<p>
	    		<button type="submit" name="register" class="register_login_button">Register</button>
	    	</p>
	    </form>
	</div>

    <!-- Footer -->
    <?php 
    include("footer.inc.php") 
    ?>
</body>
</html>