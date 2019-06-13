<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$subID = $_POST['lsubID']; // Submission ID
	$subTitle = $_POST['lsubTitle']; // Submission Title
	$subCategory = $_POST['lsubCategoryID']; // Submission Category

	switch ($_POST['lsubCategoryID']){
		case "BeActive":
			$subCategory = 1;
			break;
		case "TakeTimeOut":
			$subCategory = 2;
			break;
		case "EatWell":
			$subCategory = 3;
			break;
		case "Connect":
			$subCategory = 4;
			break;
		case "BeSupported":
			$subCategory = 5;
			break;
		case "Showers":
			$subCategory = 6;
			break;
		case "WaterDispenser":
			$subCategory = 7;
			break;
		case "Showers":
			$subCategory = 8;
			break;
		default:
			$subCategory = 1;
			break;
	}

	$subDescription = $_POST['lsubDescription']; // Submission Description
	$subLongitude = $_POST['lsubLongitude']; // Submission Longitude
	$subLatitude = $_POST['lsubLatitude']; // Submission Latitude


	//sql statements
	$delete = "DELETE FROM location_sub WHERE lsub_ID = $subID;";
	$insertLoc = "INSERT INTO location_tbl (cat_ID, loc_title, loc_description, loc_longitude, loc_latitude) VALUES ($subCategory, '$subTitle', '$subDescription', $subLongitude, $subLatitude)";
	$catCount = "UPDATE cat_tbl SET cat_count = cat_count + 1 WHERE cat_ID = $subCategory";

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
		echo "Error: " . $insertLoc . "<br>" . $conn->error;
	}

	$conn->query($catCount);

	$conn->close(); // Close connection to database
?>
