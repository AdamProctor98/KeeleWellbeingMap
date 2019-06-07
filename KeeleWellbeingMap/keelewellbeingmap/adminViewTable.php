<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database


  $tableName = $_POST['table'];
  if ($tableName == 1){
    //sql statement
    $sql = 'SELECT location_tbl.*, cat_name FROM location_tbl, category_tbl WHERE location_tbl.cat_ID = category_tbl.cat_ID ORDER BY cat_name';

    //attempt sql statement
    $result = $conn->query($sql);

    //Checks if query is successful
    if ($result->num_rows > 0) {
      // Creates a table containing all location on the map currently
      print '<div class = "table-responsive"><table class="table table-hover table-bordered" id = "locationTable"> <thead class="thead-dark"> <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Category</th>
            <th scope="col">Description</th>
            </tr> </thead> <tbody>';
      while($row = $result->fetch_assoc()) {
        print "<tr><th scope = 'row'>".$row['loc_ID']."</th>";
        print "<td>".$row['loc_title']."</td>";
        print "<td>".$row['cat_name']." <span><img src = 'media/".$row['cat_name'].".png' alt = 'logo' height = '35px'></span></td>";
        if ($row['loc_description'] == ""){
          print "<td>N/A</td></tr>";
        } else {
          print "<td>".$row['loc_description']."</td></tr>";
        }
      }
      print "</tbody></table></div>";
    } else {
      print "There are currently no locations.";
    }
  } else if ($tableName == 2){
    //sql statement
    $sql = 'SELECT event_tbl.*, location_tbl.loc_title FROM event_tbl, location_tbl WHERE event_tbl.loc_ID = location_tbl.loc_ID ORDER BY event_ID';

    //attempt sql statement
    $result = $conn->query($sql);

    //Checks if query is successful
    if ($result->num_rows > 0) {
      // Creates a table containing all location on the map currently
      print '<div class = "table-responsive"><table class="table table-hover table-bordered table-responsive" id = "eventTable"> <thead class="thead-dark"> <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Location</th>
            <th scope="col">Description</th>
            <th scope="col">Time</th>
            <th scope="col">Date</th>
            </tr> </thead> <tbody>';
      while($row = $result->fetch_assoc()) {
        print "<tr><th scope = 'row'>".$row['event_ID']."</th>";
        print "<td>".$row['event_title']."</td>";
        print "<td>".$row['loc_title']."</td>";
        print "<td>".$row['event_description']."</td>";        
        print "<td>".$row['event_time']."</td>";
        print "<td>".$row['event_date']."</td>";
        print "</tr>";
      }
      print "</tbody></table></div>";
    } else {
      print "There are currently no events.";
    }
  } else {
    $sql = 'SELECT * FROM runroute_tbl';

    //attempt sql statement
    $result = $conn->query($sql);

    //Checks if query is successful
    if ($result->num_rows > 0) {
      // Creates a table containing all location on the map currently
      print '<div class = "table-responsive"><table class="table table-hover table-bordered table-responsive" id = "runrouteTable"> <thead class="thead-dark"> <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Length</th>
            </tr> </thead> <tbody>';
      while($row = $result->fetch_assoc()) {
        print "<tr><th scope = 'row'>".$row['rr_ID']."</th>";
        print "<td>".$row['rr_name']."</td>";
        print "<td>".$row['rr_description']."</td>";        
        print "<td>".$row['rr_length']."</td>";
        print "</tr>";
      }
      print "</tbody></table></div>";
    } else {
      print "There are currently no run routes.";
    }
  }



  $conn->close(); // Close connection to database
?>
