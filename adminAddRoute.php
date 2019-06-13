<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  $rr_name = $_POST['rrName']; //Submission Name
  $rr_desc = $_POST['rrDesc']; //Submission Description
  $rr_length = $_POST['rrLength']; //Submission Length
  $rr_route = $_POST['rrCoordinates']; //Submission Route
  $rr_colour = $_POST['rrColour']; //Submission Colour
  $rr_startPoint = $_POST['rrStartP']; //Submission Start Point

  //sql statement
  $sql = "INSERT INTO runroute_tbl (cat_ID,rr_name,rr_description,rr_length,rr_route,rr_startpoint,rr_colour) VALUES (9,'$rr_name','$rr_desc','$rr_length','$rr_route','$rr_startPoint','$rr_colour')";

  // Checks is query is successful
  if ($conn->query($sql) === TRUE) {
    echo "You have successfully added a new run route to the map.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close(); // Close Connection to Database
?>
