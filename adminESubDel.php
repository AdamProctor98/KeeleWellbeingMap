<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$eventSub = $_POST['subID']; // Event Selected

	//sql statement
	$sql = "DELETE FROM event_sub WHERE esub_ID = $eventSub";
	//sql statement to update auto-increment
	$updateAI = "SET @m = (SELECT MAX(esub_ID) + 1 FROM event_sub);
				SET @s = CONCAT('ALTER TABLE event_sub AUTO_INCREMENT=', @m);
				PREPARE stmt1 FROM @s;
				EXECUTE stmt1;
				DEALLOCATE PREPARE stmt1;";

	// Checks is query is successful
	if ($conn->query($sql) === TRUE) {
	echo "Event Deleted Successfully";
	} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->query($updateAI);

	$conn->close(); // Close Connection to Database
?>