<?php
  //Connect to Database
  include_once("dbConnect.php"); //projects Server Database

  //sql statement
  $sql = 'SELECT * FROM runroute_tbl';

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
      $routeArray = array();

      $rowRoute = explode("&", $row['rr_route']);
      for($i = 0; $i <= (count($rowRoute)-1);$i++){
        $routePoints = explode(",",$rowRoute[$i]);
        $routePoints[0] = floatval($routePoints[0]);
        $routePoints[1] = floatval($routePoints[1]);
        array_push($routeArray,$routePoints);
      }


      $feature = array(
        'type' => 'Feature',
        'properties' => array(
            'icon' => $row['rr_name'],
            'color' => $row['rr_colour']
        ),
        'geometry' => array(
            'type' => 'LineString',
            'coordinates' => $routeArray
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
