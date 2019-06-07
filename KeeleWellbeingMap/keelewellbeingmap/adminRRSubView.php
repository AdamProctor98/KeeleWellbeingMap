<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	//sql statement
	$sql = 'SELECT * FROM runroute_sub';

	//attempt sql statement
	$result = $conn->query($sql);

	// Checks see if query is successful
	if ($result->num_rows == 0) {
		// If no run routes have been submitted
		print "There are no locations currently submitted.";
	} else {
		// If their are run routes to be approved
		// Creates a form for each submission
		while($row = $result->fetch_assoc()) {
			// Submission Name and Colour
		print '<div class = "card conatainer" style = "margin-bottom:10px;"><div class = "card-body" style = "width:100%;"><form action="adminRRSubAdd.php" method = "POST">
		';
			// Submission Length and Colour
		print '<div class = "form-row">
  				<div class = "col-md-6">
  					<div class = "form-group">
  					<label for = "rrsubName"><strong>Name</strong></label>
  					<input type = "hidden" name = "rrsubID" id = "rrsubID" value = "'.$row['rrsub_ID'].'">
  					<input type = "text" class = "form-control" name = "rrsubName" id = "rrsubName" value = "'.$row['rrsub_name'].'" required>
  					</div>
  				</div>
  				<div class = "col-md-6">
  					<div class = "form-group">
  					<label for = "rrsubLength"><strong>Length</strong></label>
  					<input type = "text" class = "form-control-plaintext" name = "rrsubLength" id = "rrsubLength" value = "'.$row['rrsub_length'].'" required>
  					</div>
  				</div>
  			</div>';
			// Submission Description
		print '<div class = "form-row form-group">
		  <label for = "rrsubDescription"><strong>Description:</strong></label>
			  <textarea rows="3" resize="none" id = "rrsubDescription" class = "form-control" name = "rrsubDescription">'.$row['rrsub_description'].'</textarea>
		</div>';
			// Submission Buttons
		print '	<div class="form-row" id = "rrsubButtons">
				<button type = "submit" class = "btn btn-primary form-control" onclick="javascript:alert("'.$row['rrsub_name'].' has been approved and has been added to the map. This will happen immediately.")">Approve</button>
				<button type = "button" class = "btn btn-danger form-control btnDeleteRRsub" onclick="delRoute('.$row['rrsub_ID'].')">Delete</button>
		</div>';
		print ' </form></div></div>';
		}
	}

	$conn->close(); //Close Connection with database
?>
