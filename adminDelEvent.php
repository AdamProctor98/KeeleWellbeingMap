<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$event = $_POST['eventDelete']; // Event Selected

	//sql statement
	$sql = "DELETE FROM event_tbl WHERE event_ID = $event";
	//sql statement to update auto-increment value
	$updateAI = "SET @m = (SELECT MAX(event_ID) + 1 FROM event_tbl);
				SET @s = CONCAT('ALTER TABLE event_tbl AUTO_INCREMENT=', @m);
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
