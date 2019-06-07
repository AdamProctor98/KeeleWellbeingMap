<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  //sql statement
  $sql = 'SELECT event_tbl.*, loc_longitude, loc_latitude, loc_title FROM event_tbl,location_tbl
  WHERE event_tbl.loc_ID = location_tbl.loc_ID ORDER BY event_date';

  //attempt sql statement
  $result = $conn->query($sql);

  // Checks if query is successful
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      // Creates the event view on the sidebar

      print '<div class = "card" style = "margin: 0 auto; padding=5px;"><div class="card-body" style = "padding:6px"><p><strong>Title: </strong>'.$row['event_title'].'<br />';
      print '<strong>Date: </strong>'.$row['event_date'].'<br />';
      print '<strong>Time: </strong>'.$row['event_time'].'</p>';
      print '<div id = "eventsDetails" style = "margin-top=5px;"><button type = "button" class="btn btn-info btn-block" data-toggle="collapse" data-target="#eventDetails'.$row['event_ID'].'">More Details</button>';
      print '<div id = "eventDetails'.$row['event_ID'].'" class = "collapse" style = "margin-top:5px;">';
      print '<p><strong>Location: </strong><br />'.$row['loc_title'].'<br />';
      print '<strong>Details: </strong><br />'.$row['event_description'].'</p>';
      print '</div></div>';
      print '<div style = "text-align:center; margin-top:5px;">
        <button type="button" style = "width:100%;" id="locateEvent" onClick = "flyToLoc('.$row['loc_longitude'].','.$row['loc_latitude'].')" class = "btn btn-info">Locate</button>
        <br>
      </div></div></div><br>';
    }
  } else {
      print "There are currently no event happening around keele. Please check back at a later time.";
  }

  $conn->close(); // Close Connection to database
?>





