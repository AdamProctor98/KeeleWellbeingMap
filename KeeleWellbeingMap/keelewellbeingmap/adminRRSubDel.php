<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$rrSub = $_POST['subID']; // Event Selected

	//sql statement
	$sql = "DELETE FROM runroute_sub WHERE rrsub_ID = $rrSub";
	$updateAI = "SET @m = (SELECT MAX(rrsub_ID) + 1 FROM runroute_sub);
				SET @s = CONCAT('ALTER TABLE runroute_sub AUTO_INCREMENT=', @m);
				PREPARE stmt1 FROM @s;
				EXECUTE stmt1;
				DEALLOCATE PREPARE stmt1;";

	// Checks is query is successful
	if ($conn->query($sql) === TRUE) {
	echo "Run Route Deleted Successfully";
	} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->query($updateAI);

	$conn->close(); // Close Connection to Database
	header("LOCATION:adminRunRoute.php");
?>