<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  //sql statement
  $sql = 'SELECT location_tbl.*, cat_name, cat_label FROM location_tbl, category_tbl WHERE location_tbl.cat_ID = category_tbl.cat_ID';

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
      // Creates a GeoJson containing all locations for the wellbeing map
      $feature = array(
        'type' => 'Feature',
        'properties' => array(
            'icon' => $row['cat_name'],
            'description' => "<strong>".$row['loc_title']."</strong><br>".$row['loc_description'],
            'name' => $row['cat_label'],
        ),
        'geometry' => array(
            'type' => 'Point',
            // Pass Longitude and Latitude Columns here
            'coordinates' => array($row['loc_longitude'], $row['loc_latitude'])
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
