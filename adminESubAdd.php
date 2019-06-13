<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$subID = $_POST['esubID']; // Submission ID
	$subTitle = $_POST['esubTitle']; // Submission Title
	$subLocation = $_POST['esubLocationID']; // Submission Location
	$subDescription = $_POST['esubDescription']; // Submission Description
	$subDate = $_POST['esubDate']; // Submission Date
	$subTime = $_POST['esubTime']; // Submission Time


	//sql statements
	$delete = "DELETE FROM event_sub WHERE esub_ID = $subID;";
	$insertLoc = "INSERT INTO event_tbl (loc_ID, event_title, event_description, event_date, event_time) VALUES ($subLocation, '$subTitle', '$subDescription',STR_TO_DATE('$subDate', '%Y-%m-%d'), '$subTime')";

	// Checks to see if delete query is successful
	if ($conn->query($delete) === TRUE) {
		echo "Record deleted successfully";
	} else {
	  echo "Error deleting record: " . $conn->error;
	}
	// Checks to see if insert query is successful
	if ($conn->query($insertLoc) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	header("LOCATION: adminEvent.php"); // Returns to admin page

	$conn->close(); // Close connection to database
?>
