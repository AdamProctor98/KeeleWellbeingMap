<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	//sql statement
	$sql = 'SELECT loc_ID, loc_title, loc_description, cat_name FROM location_tbl, category_tbl WHERE location_tbl.cat_ID = category_tbl.cat_ID ORDER BY cat_name, loc_ID';

	$result = $conn->query($sql); // Stores Result of Query

	// Checks to see if anything has been returned from the query
	if ($result->num_rows > 0) {
		// output data of each row
		// Creates a select box containing all the locations currently on the map
		print "<select id = 'locationDelSelect' name = 'locationDelSelect' class = 'form-control' required>

		<option value='' disabled selected>Select a location to delete...</option>";
		while($row = $result->fetch_assoc()) {
			if ($row['loc_description'] == ""){
				print "<option value=".$row['loc_ID'].">".$row['cat_name'].": ".$row['loc_title']."</option>";
			} else {
				print "<option value=".$row['loc_ID'].">".$row['cat_name'].": ".$row['loc_title']." - ".$row['loc_description']."</option>";
			}
			
		}
		print "</select>";
		print "<div class='col text-center'>
                  <br>
                  <button class='btn btn-danger btn-lg adminButton' type = 'button' data-toggle = 'modal' data-target = '#delModal'>Delete</button>
                </div>";
	} else {
		echo "0 results";
	}

	$conn->close(); // Close connection to database
?>
