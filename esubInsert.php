<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$esub_title = $_POST['eventTitle'];
	$esub_location = $_POST['eventLocation'];
	$esub_description = $_POST['eventDescription'];
	$esub_time = $_POST['eventTimeFrom']." - ".$_POST['eventTimeTo'];
	$esub_date = $_POST['eventDate'];

	//sql statement
	$sql = "INSERT INTO event_sub (loc_ID,esub_title,esub_description,esub_date,esub_time) VALUES ($esub_location,'$esub_title','$esub_description',STR_TO_DATE('$esub_date', '%Y-%m-%d'),'$esub_time')";

	// Checks is query is successful
	if ($conn->query($sql) === TRUE) {
		echo "Thank for submittitng a new event to the keele wellbeing map. You have successfully submitted the event: ".$esub_title.", which will take place on the ".$esub_date." This will be reviewed by the Sports Centre before it is approved.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close(); // Close Connection to Database
?>
