// global variables
var locationTag;
var latitudeTag;
var longitudeTag;
var latitude;
var longitude;
var zoom;

// retrieve user's geolocation to insert into search bar
function getLocation() {
	locationTag = document.getElementById("search-bar"); // retrieve search bar element from document
	if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition); // call helper to insert geolocation values into element
    } else { 
        locationTag.innerHTML = "Geolocation is not supported by this browser."; // error handling
    }
}

function showPosition(position) {
	locationTag.value = position.coords.latitude + ", " + position.coords.longitude;
}

// retrieve user's geolocation to use with parking submission form
function getLocationForSubmission() {
	// retrieve the two text input elements related to latitude and longitude
	latitudeTag = document.getElementById("latitude");
	longitudeTag = document.getElementById("longitude");
	if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(addLocationToTextbox); // call helper to insert geolocation values into element
    } else { 
        locationTag.innerHTML = "Geolocation is not supported by this browser."; // error handling
    }
}

// insert user's geolocation into the two location text input fields in the parking submission form
function addLocationToTextbox(position) {
	latitudeTag.value = position.coords.latitude;
	longitudeTag.value = position.coords.longitude;
}

// display nearby available parking spots using Google Maps API
function initMap() {
	// insert Google Maps into an existing empty results-map div
	var map = new google.maps.Map(document.getElementById('results-map'), {
	  center: {lat: 43.212384, lng: -79.895371},
	  zoom: 19, // set zoom so that buildings and driveways are clearly visible
	  mapTypeId: 'satellite'
	});

	/* MARKER 1 LABEL CONTENT*/
	var contentString1 = 
      '<h1 id="parkingHeading" class="parkingHeading">Parking Spot #1</h1>'+
      '<div id="parkingBodyContent">'+
      '<p><b>571 Urban Dr, Hamilton, ON</b><br>'+
      'Rate: $10/hour<br>'+
      'Overall Rating: 4.5/5</p>'+
      '</div>'+
      '<a href="parking.php">More info...</a>';

    /* MARKER 1 LABEL*/
    var infowindow1 = new google.maps.InfoWindow({
    content: contentString1
  	});

    /* MARKER 1*/
	var marker1 = new google.maps.Marker({
    position: {lat: 43.212345, lng: -79.895549},
    map: map,
    title: 'Hello World!'
  	});

	// display information label on click
  	marker1.addListener('click', function() {
    infowindow1.open(map, marker1);
  	});

  	/* MARKER 2 LABEL CONTENT*/
  	var contentString2 = 
      '<h1 id="parkingHeading" class="parkingHeading">Bob\'s Parking</h1>'+
      '<div id="parkingBodyContent">'+
      '<p><b>1081 Main St W, Hamilton, ON</b><br>'+
      'Rate: $15/hour<br>'+
      'Overall Rating: 4.7/5</p>'+
      '</div>'+
      '<a href="parking.php">More info...</a>';

	/* MARKER 2 LABEL*/
    var infowindow2 = new google.maps.InfoWindow({
    content: contentString2
  	});

    /* MARKER 2*/
  	var marker2 = new google.maps.Marker({
    position: {lat: 43.212285, lng: -79.895850},
    map: map,
    title: 'Hello World!'
  	});

  	// display information label on click
  	marker2.addListener('click', function() {
    infowindow2.open(map, marker2);
  	});

  	/* MARKER 3 LABEL CONTENT*/
  	var contentString3 = 
      '<h1 id="parkingHeading" class="parkingHeading">Parking - (Weekends Only)</h1>'+
      '<div id="parkingBodyContent">'+
      '<p><b>Lat: 43.256531 Long: -79.874420</b><br>'+
      'Rate: $7/hour<br>'+
      'Overall Rating: 4.1/5</p>'+
      '</div>'+
      '<a href="parking.php">More info...</a>';

    /* MARKER 3 LABEL*/
    var infowindow3 = new google.maps.InfoWindow({
    content: contentString3
  	});

    /* MARKER 3*/
  	var marker3 = new google.maps.Marker({
    position: {lat: 43.212151, lng: -79.894939},
    map: map,
    title: 'Hello World!'
  	});

  	// display information label on click
  	marker3.addListener('click', function() {
    infowindow3.open(map, marker3);
  	});
}

// JS validation for submission form input fields
function validateSubmissionForm(form) {
	var missingFieldNames = "The following required fields are missing/invalid:\n";
	var isFormValid = true;

	// retrieve all input elements from submission form that require validation
	var parkingNameElem = form.parkingName;
	var descriptionElem = form.description;
	var latitudeElem = form.latitude;
	var longitudeElem = form.longitude;

	// check if name is empty and highlight box if it is
	if (parkingNameElem.value == "") {
		missingFieldNames += "Name of Parking Spot\n";
		isFormValid = false;
		parkingNameElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		parkingNameElem.value = parkingNameElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		parkingNameElem.style.border = "none";
	}

	// check if description is empty and highlight box if it is
	if (descriptionElem.value == "") {
		missingFieldNames += "Parking Spot Description\n";
		isFormValid = false;
		descriptionElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		descriptionElem.value = descriptionElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		descriptionElem.style.border = "none";
	}

	// check if latitude is empty and highlight box if it is
	if (latitudeElem.value == "") {
		missingFieldNames += "Latitude Coordinate\n";
		isFormValid = false;
		latitudeElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		latitudeElem.value = latitudeElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		latitudeElem.style.border = "none";
	}
	
	// check if longitude is empty and highlight box if it is
	if (longitudeElem.value == "") {
		missingFieldNames += "Longitude Coordinate\n";
		isFormValid = false;
		longitudeElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		longitudeElem.value = longitudeElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		longitudeElem.style.border = "none";
	}
	
	// display alert to user in browser window with list of missinng or invalid fields
	if (!isFormValid) {
		window.alert(missingFieldNames);
	}
	return isFormValid;
}

// JS validation for registration form input fields
function validateRegistrationForm(form) {
	var missingFieldNames = "The following required fields are missing/invalid:\n";
	var isFormValid = true;

	var firstNameElem = form.firstName;
	var lastNameElem = form.lastName;
	var emailElem = form.email;
	var passwordElem = form.password;
	var confirmPasswordElem = form.confirmPassword;

	// check if first name is empty and highlight box if it is
	if (firstNameElem.value == "") {
		missingFieldNames += "First Name\n";
		isFormValid = false;
		firstNameElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		firstNameElem.value = firstNameElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		firstNameElem.style.border = "none";
	}

	// check if last name is empty and highlight box if it is
	if (lastNameElem.value == "") {
		missingFieldNames += "Last Name\n";
		isFormValid = false;
		lastNameElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		lastNameElem.value = lastNameElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		lastNameElem.style.border = "none";
	}

	// check if email address is not valid format and highlight box if it isn't
	if (!(/^[^@]+@[^@]+\.[a-zAZ]{2,}$/.test(emailElem.value))) {
		missingFieldNames += "Email\n";
		isFormValid = false;
		emailElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		emailElem.value = emailElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		emailElem.style.border = "none";
	}
	
	// check if password is strong enough and highlight password text box if it isn't
	if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*-])(?=.{8,})/.test(passwordElem.value))) {
		missingFieldNames += 'Password must be atleast 8 characters long and contain uppercase, lowercase, number, and a special character: !@#$%^&*-\n';
		isFormValid = false;
		passwordElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		passwordElem.value = passwordElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		passwordElem.style.border = "none";
	}

	// check if password confirmation is empty and highlight box if it is
	if (confirmPasswordElem.value == "") {
		missingFieldNames += "Confirm Password\n";
		isFormValid = false;
		confirmPasswordElem.style.border = "1px solid red";
	} else {
		// sanitize input when its not empty
		confirmPasswordElem.value = confirmPasswordElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		confirmPasswordElem.style.border = "none";
	}

	// check if both passwords match and higlight password fields it they don't
	if (passwordElem.value != confirmPasswordElem.value) {
		window.alert("Passwords do not match!"); // alert user if password mismatch
		isFormValid = false;
		passwordElem.style.border = "1px solid red";
		confirmPasswordElem.style.border = "1px solid red";
	}
	
	// display alert to user in browser window with list of missinng or invalid fields
	if (!isFormValid) {
		window.alert(missingFieldNames);
	}
	return isFormValid;
}

// JS validation for search form input fields
function validateSearch(form) {
	var searchBar = form.location;

	// ensure search bar isn't empty
	if (searchBar.value == "") {
		isFormValid = false;
		searchBar.style.border = "1px solid red";
		return false;
	} else {
		// sanitize search bar input value
		searchBar.value = searchBar.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		searchBar.style.border = "none";
		return true;
	}
}

// JS validation for login form input fields
function validateLoginForm(form) {

	var missingFieldNames = "The following required fields are missing/invalid:\n";
	var isFormValid = true;

	var emailElem = form.email;
	var passwordElem = form.password;

	// checks for invalid email formats and highlights email input if invalid
	if (!(/^[^@]+@[^@]+\.[a-zAZ]{2,}$/.test(emailElem.value))) {
		missingFieldNames += "Email\n";
		isFormValid = false;
		emailElem.style.border = "1px solid red";
	} else {
		// sanitize input
		emailElem.value = emailElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		emailElem.style.border = "none";
	}
	
	// ensures password field is not empty
	if (passwordElem.value == "") {
		missingFieldNames += "Password\n";
		isFormValid = false;
		passwordElem.style.border = "1px solid red";
	} else {
		// sanitize input
		passwordElem.value = passwordElem.value.replace(/&/g,"&amp;").replace(/</g,"&lt").replace(/>/g,"&gt");
		passwordElem.style.border = "none";
	}

	// display alert to user in browser window with list of missinng or invalid fields
	if (!isFormValid) {
		window.alert(missingFieldNames);
	}
	return isFormValid;
}
