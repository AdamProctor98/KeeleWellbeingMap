<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	//sql statement
	$sql = 'SELECT * FROM runroute_tbl';

	$result = $conn->query($sql); // Stores Result of Query

	// Checks to see if anything has been returned from the query
	if ($result->num_rows > 0) {
		// output data of each row
		// Creates a select box containing all the run routes currently on the map
		print "<select id = 'rrDelSelect' name = 'rrDelSelect' class = 'form-control' required>

		<option value='' disabled selected>Select a run route to delete...</option>";
		while($row = $result->fetch_assoc()) {
				print "<option value=".$row['rr_ID'].">".$row['rr_name'].": ".$row['rr_description']."</option>";
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
