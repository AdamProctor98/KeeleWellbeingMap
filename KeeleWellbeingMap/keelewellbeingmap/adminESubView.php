<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	//sql statement
	$sql = 'SELECT event_sub.*, loc_title FROM event_sub, location_tbl WHERE event_sub.loc_ID = location_tbl.loc_ID;';

	//attempt sql statement
	$result = $conn->query($sql);

	// Checks see if query is successful
	if ($result->num_rows == 0) {
		// If no events have been submitted
		print "There are no events currently submitted.";
	} else {
		// If their are events to be approved
		// Creates a form for each submission
		while($row = $result->fetch_assoc()) {
			// Submission Title
		print '<div class = "card conatainer"><div class = "card-body"><form action="adminESubAdd.php" method = "POST">
		<div class = "form-group row">
		  <label for = "esubTitle" class = "col-sm-3 col-form-label"><strong>Title:</strong></label>
		  <div class="col-sm-9" id = "esubTitle">
			<input type = "hidden" id = "esubID" name = "esubID" value = "'.$row['esub_ID'].'">
			<input type = "text" class = "form-control" name = "esubTitle" value = "'.$row['esub_title'].'">
		  </div>
		</div>';
			// Submission Location
		print '<div class = "form-group row">
		  <label for = "subLocation" class = "col-sm-3 col-form-label"><strong>Location:</strong></label>
		  <div class="col-sm-9">
		  	<input type = "hidden" id = "esubLocationID" readonly class = "form-control-plaintext" name = "esubLocationID" value = "'.$row['loc_ID'].'">
	  		<input type = "text" id = "esubLocation" readonly class = "form-control-plaintext" name = "esubLocation" value = "'.$row['loc_title'].'">
			  
			  
		  </div>
		</div>';
			// Submission Description
		print '<div class = "form-group row">
		  <label for = "esubDescription" class = "col-sm-3 col-form-label"><strong>Description:</strong></label>
		  <div class="col-sm-9">
			  <textarea rows="3" resize="none" id = "esubDescription" class = "form-control" name = "esubDescription">'.$row['esub_description'].'</textarea>
		  </div>
		</div>';
			//Submission Date & Time
		print '<div class = "row">
		<div class = "form-group col-md-6">
			<lable for = "esubDate" class = "col-sm-3 col-form-label"><strong>Date:</strong></label>
			<div class = "col-sm-9">
			<input type = "text" id = "esubDate" name = "esubDate" readonly class = "form-control-plaintext" value = "'.$row['esub_date'].'"></div>
		</div>
		<div class = "form-group col-md-6">
			<lable for = "esubTime" class = "col-sm-3 col-form-label"><strong>Time:</strong></label>
			<div class = "col-sm-9">
			<input type = "text" id = "esubTime" name = "esubTime" readonly class = "form-control-plaintext" value = "'.$row['esub_time'].'"></div>
		</div>
		</div>
		<hr>';
			// Submission Buttons
		print '	<div class="form-row" id = "esubButtons">
				<button type = "submit" class = "btn btn-primary form-control" onclick="javascript:alert("'.$row['esub_title'].' has been approved and has been added to the map. This will happen immediately.")">Approve</button>
				<button type = "button" class = "btn btn-danger form-control btnDeleteEsub" onclick="delEvent('.$row['esub_ID'].')">Delete</button>
		</div>';
		print ' </form></div></div>';
		}
	}

	$conn->close(); //Close Connection with database
	//exit;
?>
