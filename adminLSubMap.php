<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  //sql statement
  $sql = 'SELECT location_sub.*, cat_name FROM location_sub, category_tbl WHERE location_sub.cat_ID = category_tbl.cat_ID';

  //attempt sql statement
  $result = $conn->query($sql);

  //geojson array
  $geojson = array(
    'type' => 'FeatureCollection',
    'features' => array()
  );

    // output data of each row
    while($row = $result->fetch_assoc()) {
      // Creates a GeoJson conating all submitted locations
      $feature = array(
        'type' => 'Feature',
        'properties' => array(
            'icon' => $row['cat_name'],
            'description' => "<strong>".$row['lsub_title']."</strong><br>".$row['lsub_description'],
        ),
        'geometry' => array(
            'type' => 'Point',
            // Pass Longitude and Latitude Columns here
            'coordinates' => array($row['lsub_longitude'], $row['lsub_latitude'])
        )


      );
      // Add feature arrays to feature collection array
      array_push($geojson['features'], $feature);
    }


  echo json_encode($geojson, JSON_NUMERIC_CHECK); // Return GeoJson
  $conn->close(); // Close connection to database
?>
