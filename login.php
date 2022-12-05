<?php
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);
include('server.php') 
?>

<?php 
$title = 'Login';
include("head.inc.php") 
?>
<body>
    <!-- Navigation Bar -->
    <?php 
    $active = 'login';
    include("navbar.inc.php");
    ?>

    <!-- Page Content -->
    <br>
    <div class="content" role="form">

		<h1>Login</h1>
		<hr>

		<!-- Login Form -->
		<form method="post" action="login.php" onsubmit="return validateLoginForm(this);">
	    	<p>
	    		Email:<br>
	    		<input type="email" name="email" placeholder="Enter Email" id="email" required>
	    	</p>
	    	<p>
	    		Password:<br>
	    		<input type="password" name="password" placeholder="Enter Password" id="password" required>
	    	</p>
	    	<button type="submit" name="login" class="register_login_button">Login</button>
	    </form>

	</div>

    <!-- Footer -->
    <?php 
    include("footer.inc.php") 
    ?>
</body>
</html>