<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$loc_title = $_POST['locTitle']; //Submission title
	switch ($_POST['locCategory']){ //Submission category
		case 0:
			$loc_cat = 1;
			break;
		case 1:
			$loc_cat = 2;
			break;
		case 2:
			$loc_cat = 3;
			break;
		case 3:
			$loc_cat = 4;
			break;
		case 4:
			$loc_cat = 5;
			break;
		case 5:
			$loc_cat = 6;
			break;
		case 6:
			$loc_cat = 7;
			break;
	  	case 7:
	  		$loc_cat = 8;
	  		break;
		default:
			$loc_cat = 1;
			break;
	}
	
	$loc_desc = $_POST['locDescription']; //Submission Description
	$loc_long = $_POST['locLong']; //Submission Longitude
	$loc_lat = $_POST['locLat']; //Submission Latitude

	//sql statement
	$sql = "INSERT INTO location_sub (cat_ID,lsub_title,lsub_description,lsub_longitude,lsub_latitude) VALUES ($loc_cat,'$loc_title','$loc_desc',$loc_long,$loc_lat)";

	// Checks is query is successful
	if ($conn->query($sql) === TRUE) {
		echo "Thank for submittitng a new location to the keele wellbeing map. You have successfully submitted the location: ".$loc_title.". This will be reviewed by the Sports Centre before it is approved.";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close(); // Close Connection to Database
	//exit;
?>
