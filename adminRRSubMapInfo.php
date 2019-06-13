<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  //sql statement
  $sql = 'SELECT runroute_sub.*, cat_name, cat_label FROM runroute_sub, category_tbl WHERE runroute_sub.cat_ID = category_tbl.cat_ID';

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
      $startPoint = explode(",",$row['rrsub_startpoint']);
      $startPoint[0]= floatval($startPoint[0]);
      $startPoint[1] = floatval($startPoint[1]);


      $feature = array(
        'type' => 'Feature',
        'properties' => array(
            'icon' => $row['cat_name'],
            'description' => "<strong>".$row['rrsub_name']."</strong><br>".$row['rrsub_length']."<br>".$row['rrsub_description'],
            'name' => $row['cat_label'],
        ),
        'geometry' => array(
            'type' => 'Point',
            // Pass StartPoint here here
            'coordinates' => array($startPoint[0],$startPoint[1])
        )
        // Pass other attribute columns here

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
