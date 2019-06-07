<?php
    //Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$route = $_POST['rrDelete']; //Route Selected to Delete

	//sql statement
	$sql = "DELETE FROM runroute_tbl WHERE rr_ID = $route";
	//sql statement to update auto-increment
	$updateAI = "SET @m = (SELECT MAX(loc_ID) + 1 FROM runroute_tbl);
				SET @s = CONCAT('ALTER TABLE runroute_tbl AUTO_INCREMENT=', @m);
				PREPARE stmt1 FROM @s;
				EXECUTE stmt1;
				DEALLOCATE PREPARE stmt1;";
	
	$updateCatCount = "UPDATE cat_tbl SET cat_count = cat_count - 1 WHERE cat_ID = 9";
	// Checks if query is successful
	if ($conn->query($sql) === TRUE) {
		echo "Route has been deleted successfully";
	} else {
		echo "Error: deleting record: " . $conn->error;
	}

	$conn->query($updateAI);



	$conn->close(); // Close Database Connection


?>
