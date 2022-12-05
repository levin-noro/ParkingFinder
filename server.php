<?php
// User submits the registration form
if (isset($_POST['register'])) {
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		
		// check if the submitted email address is already associated with an account
		$statement = $pdo->prepare('SELECT email FROM users WHERE email=:email');
		$statement->bindValue(':email',$_POST['email']);
		$statement->execute();

		// if the email address was not found in the database, proceed with registration
		if ($statement->rowCount()==0) {
			$pdo1 = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');
			$pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//insert registration form data into users table
			$statement = $pdo1->prepare('INSERT INTO users (fname, lname, email, password) VALUES(:fname, :lname, :email, :password)');
			$statement->bindValue(':fname',$_POST['firstName']);
			$statement->bindValue(':lname',$_POST['lastName']);
			$statement->bindValue(':email',$_POST['email']);
			$statement->bindValue(':password',sha1($_POST['password']));
			$statement->execute();
			//redirect to login page as a sign of successfull registration
			header("Location: https://noronl.comp4ww3.com/login.php");
			exit();
		} else  {
			echo '<script>console.log("Registration error")</script>';
		}
	} catch (PDOException $e) { 
		echo $e->getMessage();
	}
}

// User submits the registration form
if (isset($_POST['login'])) {
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');

		// check if the login email is registered in users table
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$statement = $pdo->prepare('SELECT id FROM users WHERE email=:email AND password=:password');
		$statement->bindValue(':email',$_POST['email']);
		$statement->bindValue(':password',sha1($_POST['password']));
		$statement->execute();

		// match found. proceed with login
		if ($statement->rowCount()>0) {
			$owner_id = $statement->fetchColumn();
			// session start and initialize session data
			session_start();
        	$_SESSION['isLoggedIn'] = true;
        	$_SESSION['user_id'] = $owner_id;
        	$_SESSION['email'] = $_POST['email'];
        	//redirect to home page as a sign of successful login
        	header("Location: https://noronl.comp4ww3.com/index.php");
			exit();
		} else {
			echo "Login failed";
		}
	} catch (PDOException $e) { 
		echo $e->getMessage();
	}
}

// User submits the parking spot submission form
if (isset($_POST['submission'])) {

	$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// retrieve logging user's id from database
	$statement = $pdo->prepare('SELECT id FROM users WHERE email=:email');
	$statement->bindValue(':email',$_SESSION['email']);
	$statement->execute();
	$owner_id = $statement->fetchColumn();

	try {
		$pdo1 = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');
		$pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// add new parking to database using the data from the parking submission form
		$statement = $pdo1->prepare('INSERT INTO parkings (name, description, owner_id, latitude, longitude, rate) VALUES(:parkingName, :description, :owner_id, :latitude, :longitude, :rate)');
		$statement->bindValue(':parkingName',$_POST['parkingName']);
		$statement->bindValue(':description',$_POST['description']);
		$statement->bindValue(':owner_id',$owner_id);
		$statement->bindValue(':latitude',$_POST['latitude']);
		$statement->bindValue(':longitude',$_POST['longitude']);
		$statement->bindValue(':rate',$_POST['rate']);
		$statement->execute();
		//redirect to search page as a sign of successful submission
		header("Location: https://noronl.comp4ww3.com/search.php");
		exit();
	} catch (PDOException $e) { 
		echo $e->getMessage();
	}
}

// User submits a search for a parking spot
if (isset($_POST['search'])) {
	$_SESSION['searchString'] = $_POST['searchString'];
}

// User submits a review for a parking spot
if (isset($_POST['submit_review'])) {
	try {
		// retrieve the parking id and the user id from the session
		$reviewer_id = $_SESSION['user_id'];
		$parking_id = $_SESSION['parking_id'];

		$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'levin', 'test');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// check if a user has already reviewed this parking spot
		$statement = $pdo->prepare('SELECT * FROM reviews WHERE reviewer_id=:reviewer_id AND parking_id=:parking_id');
		$statement->bindValue(':reviewer_id',$reviewer_id);
		$statement->bindValue(':parking_id',$parking_id);
		$statement->execute();

		// the user hasn't reviewed this spot before, proceed with review submission
		if ($statement->rowCount()==0) {
			$statement = $pdo->prepare('INSERT INTO reviews (parking_id, reviewer_id, review, rating) VALUES(:parking_id, :reviewer_id, :review, :rating)');
			$statement->bindValue(':parking_id',$parking_id);
			$statement->bindValue(':reviewer_id',$reviewer_id);
			$statement->bindValue(':review',$_POST['review']);
			$statement->bindValue(':rating',$_POST['rating']);
			$statement->execute();
		}
	} catch (PDOException $e) {
		echo "<script>console.log(\"{$e->getMessage()}\")</script>";
	}
}
?>