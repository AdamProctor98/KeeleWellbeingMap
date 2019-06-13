<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  //sql statement
  $sql = 'SELECT runroute_tbl.*, cat_name, cat_label FROM runroute_tbl, category_tbl WHERE runroute_tbl.cat_ID = category_tbl.cat_ID';

  //geojson array
  $geojson = array(
    'type' => 'FeatureCollection',
    'features' => array()
  );

  //attempt sql statement
  $result = $conn->query($sql);

  //Checks if query is successful
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      // Creates a GeoJson containing all run routes information for the wellbeing map
      $startPoint = explode(",",$row['rr_startpoint']);
      $startPoint[0]= floatval($startPoint[0]);
      $startPoint[1] = floatval($startPoint[1]);


      $feature = array(
        'type' => 'Feature',
        'properties' => array(
            'icon' => $row['cat_name'],
            'description' => "<strong>".$row['rr_name']."</strong><br>".$row['rr_length']."<br>".$row['rr_description'],
            'name' => $row['cat_label'],
        ),
        'geometry' => array(
            'type' => 'Point',
            // Pass Start Point Columns here
            'coordinates' => array($startPoint[0],$startPoint[1])
        )

      );
      // Add feature arrays to feature collection array
      array_push($geojson['features'], $feature);
    }
  } else {
      echo "0 results";
  }

  echo json_encode($geojson, JSON_NUMERIC_CHECK); // Returns GeoJson created
  $conn->close(); // Closes Connection to database
?>
