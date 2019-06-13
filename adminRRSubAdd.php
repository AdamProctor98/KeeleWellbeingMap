<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$subID = $_POST['rrsubID']; // Submission ID
	$subName = $_POST['rrsubName']; // Submission Name
	$subDescription = $_POST['rrsubDescription']; // Submission Description
	$subLength = $_POST['rrsubLength']; // Submission Length

	$fetchRoute = "SELECT * FROM runroute_sub WHERE rrsub_ID = $subID";

	$route = $conn->query($fetchRoute);
	$result = $route->fetch_assoc();
	$subRoute = $result['rrsub_route'];
	$subSP = $result['rrsub_startpoint'];
	$subColour = $result['rrsub_colour'];


	//sql statements
	$delete = "DELETE FROM runroute_sub WHERE rrsub_ID = $subID;";
	$insertLoc = "INSERT INTO runroute_tbl (cat_ID, rr_name, rr_description, rr_length, rr_route, rr_startpoint, rr_colour) VALUES (9, '$subName', '$subDescription','$subLength', '$subRoute', '$subSP', '$subColour')";

	
	// Checks to see if insert query is successful
	if ($conn->query($insertLoc) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	// Checks to see if delete query is successful
	if ($conn->query($delete) === TRUE) {
		echo "Record deleted successfully";
	} else {
  		echo "Error deleting record: " . $conn->error;
	}
	

	header("LOCATION: adminRunRoute.php"); // Returns to admin page*/

	$conn->close(); // Close connection to database
?>
