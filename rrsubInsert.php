<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  $rr_name = $_POST['rrName']; //Submission Name
  $rr_desc = $_POST['rrDesc']; //Submission Description
  $rr_length = $_POST['rrLength']; //Submission Length
  $rr_route = $_POST['rrCoordinates']; //Submission Route
  $rr_colour = $_POST['rrColour'];
  $rr_startPoint = $_POST['rrStartP'];

  //sql statement
  $sql = "INSERT INTO runroute_sub (cat_ID,rrsub_name,rrsub_description,rrsub_length,rrsub_route,rrsub_startpoint,rrsub_colour) VALUES (9,'$rr_name','$rr_desc','$rr_length','$rr_route','$rr_startPoint','$rr_colour')";

  // Checks is query is successful
  if ($conn->query($sql) === TRUE) {
    echo "Thank for submittitng a new running route to the keele wellbeing map. You have successfully submitted the run route: ".$rr_name.". This will be reviewed by the Sports Centre before it is approved.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close(); // Close Connection to Database
?>
