
<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	$loc_title = $_POST['locTitle']; //Location Title

	// Location Category depending on selection made
	switch ($_POST['locCategory']){
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

	$loc_desc = $_POST['locDescription']; //Location Description
	$loc_long = $_POST['locLong']; //Location longitude
	$loc_lat = $_POST['locLat']; //Location Latitude

	//sql statement
	$sql = "INSERT INTO location_tbl (cat_ID, loc_title, loc_description, loc_longitude, loc_latitude) VALUES ($loc_cat, '$loc_title', '$loc_desc', $loc_long, $loc_lat)";
	$catCount = "UPDATE cat_tbl SET cat_count = cat_count + 1 WHERE cat_ID = $loc_cat";

	//Checks if query is successful
	if ($conn->query($sql) === TRUE) {
	echo "New record has been added successfully";
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->query($catCount);

	//Close connection to Database
	$conn->close();
?>
