<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	//sql statement
	$sql = 'SELECT * FROM event_tbl ORDER BY event_ID';

	$result = $conn->query($sql);

	// Checks to see if the query returns a result
	if ($result->num_rows > 0) {
	// output data of each row
	// Creates select box containing all current events
	print "<select id = 'eventDelSelect' name = 'eventDelSelect' class = 'form-control' required>
	<option value='' disabled selected>Select an event to delete...</option>";
	while($row = $result->fetch_assoc()) {
	  print "<option value = '".$row['event_ID']."'>".$row['event_title'].": ".$row['event_date'];
	}
	print "</select>";
	print "<div class='col text-center'>
                  <br>
                  <button class='btn btn-danger btn-lg adminButton' type = 'button' data-toggle = 'modal' data-target = '#delModal'>Delete</button>
                </div>";

	} else {
	  print "There are currently no events. Please check back at a later time.";
	}

	$conn->close(); //Close connection to database
?>
