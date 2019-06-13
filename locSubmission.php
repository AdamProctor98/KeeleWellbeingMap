<!DOCTYPE html>
<html>

  <head>
    <title>Keele Wellbeing Map - Student Submission</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.css' rel='stylesheet' />
  </head>
  <style>
	#map { width:100%; height:500px; display:flex;}
  </style>
  <body>
    <nav class="navbar navbar-light" style = "background-color: #272548;">
      <a class="navbar-brand" href="#">
        <img src="media/KeeleUni-WHITE.png" alt="Keele University Logo" height="42" width="86">
      </a>
    </nav>
    <div class="jumbotron">
      <div class = "container">
      <h1 class="display-5">Are we missing something?</h1>
      <p class="lead">Filling in this form will allow you to suggest a new location to the Sports
        Centre to add to the map. Please be aware that all submissions are reviewed by the
        Sports Centre before being added to the map.</p>
      <hr class="my-4">
      <a class="btn btn-primary btn-lg" href="index.php" role="button">Return To Map</a>
    </div>
    </div>
	
    <div class="container">
      <div class = "card" style="margin-bottom:50px;">
        <div class = "card-body" name = "addLocCardBody">
          <h4>Location Submission Form:</h4>
		  <!-- Submission Form -->
          <form id = "subLocForm">
            <div class = "form-row">
              <div class = "form-group col-md-6">
                <label for="addLocTitle">Name:</label>
                <input name = "locName" type:"text" class="form-control" id="addLocTitle" placeholder="Please enter a name for your location..." maxlength="25" required>
              </div>
              <div class = "form-group col-md-6">
                <label for="selectCategory">Category:</label>
                <select name = "selectCategory" class = "form-control" id = "selectCategory" required>
                  <option value="" disabled selected>Please select a category...</option>
                  <option value="0">Be Active</option>
                  <option value="1">Take Time Out</option>
                  <option value="2">Eat Well</option>
                  <option value="3">Connect</option>
                  <option value="4">Be Supported</option>
                  <option value="5">Showers</option>
                  <option value="6">Water Dispenser</option>
                  <option value="7">Medical</option>
                </select>
              </div>
            </div>


            <div class = "form-group">
              <label for = "map">Click and Drag the marker to the location:
              <input name="longitude" id="longitude" type = "hidden" value = "">
                  <input name="latitude" id="latitude" type = "hidden" value = "">
                </label>
              <div id = "map"></div>

            </div>

            <div class = "form-row">
                    <div id = "markerPlaced" name = "markerPlaced"></div>
              </div>

            <div class = "form-group">
              <label for = "addLocDescription">Description:</label>
              <textarea name = "addLocDescription" id = "addLocDescription" class = "form-control" rows = "3" placeholder="Please provide a few words to describe your location..."></textarea>
            </div>
            <hr>
            <div class="form-row">
              <div class="col text-center">
                <button class="btn btn-success btn-lg" type = "submit" style="width:40%;">SUBMIT</button>
              </div>
            </div>
          </form>
		  <!---->
        </div>
      </div>
    </div>
  </body>

  <script type="text/javascript">
    $( "#subLocForm" ).submit(function(event) {
      var locTitle = $('#addLocTitle').val();
      var locCategory = $('#selectCategory').val();
      var locLong = $('#longitude').val();
      var locLat = $('#latitude').val();
      var locDescription = $('#addLocDescription').val();

      if (locLong === "" || locLat === ""){
        document.getElementById('markerPlaced').innerHTML = "<strong style = 'color:red;'>Location has not been chosen!</strong>";
      } else {
        $.ajax({
          url : 'lsubInsert.php',
          type : 'POST',
          async: false,
          data: {locTitle : locTitle, locCategory : locCategory, locDescription : locDescription,
          locLong : locLong, locLat: locLat},
          success: function(msg){
            alert (msg);
            window.location.href = "index.php";
          }
        });
      }
      event.preventDefault();
    });
  </script>

  <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoidzZnNzAiLCJhIjoiY2pubmJuenlyMDBucTN3bzFmeGh0Y2F5ZiJ9.bbEJovAXpADYG62sxMd-cQ';
    //var coordinates = document.getElementById('inputCoordinates');
    var bounds = [
      [-2.2923906154337885, 52.991730703546295], // Southwest Coordinates
      [-2.2486869754334577, 53.00926483916135]  // Northeast Coordinates
    ];
    var longitude = document.getElementById('longitude');
    var latitude = document.getElementById('latitude');
    var submissionMap = new mapboxgl.Map({
      container: 'map', // container id
      style: 'mapbox://styles/w6g70/cjqf41k6niicn2rt7w2q0zkk4', // stylesheet location
      center: [-2.2739505947879763,53.00266947632235], // starting position [lng, lat]
      zoom: 15, // starting zoom
      minZoom: 15,
      maxBounds:bounds
    });

    var marker = new mapboxgl.Marker({
        draggable: true
    })
        .setLngLat([-2.2739505947879763,53.00266947632235])
        .addTo(submissionMap);

    function onDragEnd() {
        var lngLat = marker.getLngLat();
        longitude.value = lngLat.lng
        latitude.value = lngLat.lat;
        document.getElementById('markerPlaced').innerHTML = "<strong>Location has been chosen!</strong>";
    }

    marker.on('dragend', onDragEnd);
  </script>

</html>
