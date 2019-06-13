<?php

	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	//sql statement
	$sql = 'SELECT loc_title, loc_ID,loc_description, cat_name FROM location_tbl, category_tbl WHERE location_tbl.cat_ID = category_tbl.cat_ID ORDER BY cat_name, loc_ID';

	$result = $conn->query($sql);

	// Checks if query returns anything
	if ($result->num_rows > 0) {
		// output data of each row
		// Creates a select box conatining all locations for events
		print "<select id = 'addeventLocSelect' name = 'addeventLocSelect' class = 'form-control' required>
		<option value='' disabled selected>Select a location ...</option>";
		while($row = $result->fetch_assoc()) {
			if ($row['loc_description'] == ""){
				print "<option value = '".$row['loc_ID']."'>".$row['cat_name'].": ".$row['loc_title']."</option>";
			} else {
				print "<option value = '".$row['loc_ID']."'>".$row['cat_name'].": ".$row['loc_title']." - ".$row['loc_description']."</option>";
			}
		  
		}
		print "</select>";
	} else {
	  print "0 results";
	}

  $conn->close(); // Close connection to database
?>
