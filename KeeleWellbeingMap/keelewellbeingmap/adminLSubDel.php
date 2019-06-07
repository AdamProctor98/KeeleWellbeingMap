<?php
  //Connect to Database
	include_once("dbConnect.php"); //projects Server Database

  $submission = $_POST['subID']; // Submission ID

  //sql statement
  $sql = "DELETE FROM location_sub WHERE lsub_ID = $submission";

	//Checks if query is successful
  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
      echo "Error deleting record: " . $conn->error;
  }



  $conn->close(); // Close Database Connection
?>
