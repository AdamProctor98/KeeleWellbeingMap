<?php
	//Connect to Database
	include_once("dbConnect.php"); //projects Server Database

	//sql statement
	$sql = 'SELECT location_sub.*, cat_name FROM location_sub, category_tbl WHERE location_sub.cat_ID = category_tbl.cat_ID;';

	//attempt sql statement
	$result = $conn->query($sql);

	// Checks see if query is successful
	if ($result->num_rows == 0) {
		// If no locations have been submitted
		print "There are no locations currently submitted.";
	} else {
		// If their are locations to be approved
		// Creates a form for each submission
		while($row = $result->fetch_assoc()) {
			// Submission Title
		  print '<hr class="my-4"><form action="adminLSubAdd.php" method = "POST">
				  <div class = "form-group row">
					  <label for = "lsubTitle" class = "col-sm-3 col-form-label">Title:</label>
					  <div class="col-sm-9" id = "subTitle">
						<input type = "hidden" id = "lsubID" name = "lsubID" value = "'.$row['lsub_ID'].'">
						<input type = "text" class = "form-control" name = "lsubTitle" value = "'.$row['lsub_title'].'">
					  </div>
				  </div>';
			// Submission Category
		  print '<div class = "form-group row">
					  <label for = "subCategory" class = "col-sm-3 col-form-label">Category:</label>
					  <div class="col-sm-9">
					  		<input type = "hidden" id = "lsubCategoryID" value = "'.$row['cat_ID'].'">
						  <input type = "text" id = "lsubCategoryID" readonly class = "form-control-plaintext" name = "lsubCategoryID" value = "'.$row['cat_name'].'">
					  </div>
				  </div>';
		// Submission Description
		print '<div class = "form-group row">
				  <label for = "lsubDescription" class = "col-sm-3 col-form-label">Description:</label>
				  <div class="col-sm-9">
					  <textarea rows="3" resize="none" id = "lsubDescription" class = "form-control" name = "lsubDescription">'.$row['lsub_description'].'</textarea>
				  </div>
			  </div>';
	  	print '<input type = "hidden" id = "lsubLongitude" name = "lsubLongitude" value = "'.$row['lsub_longitude'].'">
				<input type="hidden" id = "lsubLatitude" name = "lsubLatitude" value = "'.$row['lsub_latitude'].'">';
			// Submission Buttons
		  print '	<div class="form-row">
							<button type = "submit" class = "btn btn-primary form-control subAddBtn" onclick="javascript:alert("'.$row['lsub_title'].' has been approved and has been added to the map. This will happen immediately.")">Approve</button>
								<button type = "button" class = "btn btn-danger form-control subDelBtn" onclick="delLoc('.$row['lsub_ID'].')">Delete</button>
					</div>';
		  print ' </form>';
		}
	}

	$conn->close(); //Close Connection with database
	//exit;
?>
