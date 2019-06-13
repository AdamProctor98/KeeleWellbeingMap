<?php
    //Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$location = $_POST['locationDelete']; //Location Selected to Delete

	$locCatFetch = "SELECT * FROM location_tbl WHERE loc_ID = $location";
	$result = $conn->query($locCatFetch);
	$row = $result->fetch_assoc();
	$locCat = $row['cat_ID'];

	//sql statement
	$sql = "DELETE FROM location_tbl WHERE loc_ID = $location";
	//sql statement to update auto-increment
	$updateAI = "SET @m = (SELECT MAX(loc_ID) + 1 FROM location_tbl);
				SET @s = CONCAT('ALTER TABLE location_tbl AUTO_INCREMENT=', @m);
				PREPARE stmt1 FROM @s;
				EXECUTE stmt1;
				DEALLOCATE PREPARE stmt1;";
	
	$updateCatCount = "UPDATE cat_tbl SET cat_count = cat_count - 1 WHERE cat_ID = $locCat";
	// Checks if query is successful
	if ($conn->query($sql) === TRUE) {
		echo "Location has been deleted successfully";
	} else {
		echo "Error: deleting record: " . $conn->error;
	}

	$conn->query($updateAI);



	$conn->close(); // Close Database Connection


?>
