<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$location = $_POST['eventLocation']; //Event location Selected
	$title = $_POST['eventTitle']; //Event Title
	$description = $_POST['eventDescription']; //Event Description
	$date = $_POST['eventDate']; //Event Date
	$time = $_POST['eventTimeFrom']." - ".$_POST['eventTimeTo']; //Event Time

	//sql statement
	$sql = "INSERT INTO event_tbl (loc_ID, event_title, event_description, event_date, event_time) VALUES ($location, '$title', '$description', STR_TO_DATE('$date', '%Y-%m-%d'), '$time')";
	//Checks if query is successful
	if ($conn->query($sql) === TRUE) {
		echo "The event has been successfully and will be shown on the home page.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close(); //Close COnnection to Database
?>
