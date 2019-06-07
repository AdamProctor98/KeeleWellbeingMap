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
    <!-- Colour Picker: Provided by Spectrum -->

    <script src='spectrum.js'></script>
    <link rel='stylesheet' href='styles/spectrum.css' />
  </head>
  <style>
    #map { width:100%; height:500px; display:flex;}
  </style>
  <body>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css' type='text/css'/>
    <script src='https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js'></script>

    <nav class="navbar navbar-light" style = "background-color: #272548;">
      <a class="navbar-brand" href="#">
        <img src="media/KeeleUni-WHITE.png" alt="Keele University Logo" height="42" width="86">
      </a>
    </nav>
    <div class="jumbotron">
      <div class = "container">
      <h1 class="display-5">Are we missing something?</h1>
      <p class="lead">Filling in this form will allow you to suggest a new run route to the Sports
        Centre to add to the map. Please be aware that all submissions are reviewed by the
        Sports Centre before being added to the map.</p>
      <hr class="my-4">
      <a class="btn btn-primary btn-lg" href="index.php" role="button">Return To Map</a>
    </div>
    </div>

    <div class="container">
      <div class = "card" style="margin-bottom:50px;">
        <div class = "card-body" name = "addRRCardBody">
          <h4>Please complete the form below to add a new run route:</h4>
          <!-- New route Form -->
          <form id = "subForm">
            <div class = "form-row form-group">
              <div class = "col-md-9">
                <label for = "routeName">Name</label>
                <input class = "form-control" id = "routeName" name = "routeName" placeholder = "Please enter the name of the route..." required>
              </div>
              <div class = "col-md-3">
                <label for = "routeCol">Colour</label><br>
                <input type="text" class="colourPicker" name = "routeCol" id = "routeCol">
                <em id = "colConfirmation">Colour not chosen</em>
              </div>
            </div>

            <div class = "form-row form-group">
              <label for = "map">Plot run route <button type = "button" class = "btn btn-primary" id = "resizeAddMap">Resize Map</button><br><small>Click the button in the top left corner of the map to begin
              plotting your run route. Once you have plotted the last point for the route, please click that point again to finalise the route. If
              you wish to start again, select the run you have just plotted with your mouse and select the delete button (Bin) in the top left corner.
              Please be aware that if you draw more than one route on the map, only the first route drawn will be submitted.</small></label>
              <div id='map'></div>

            </div>
            <div class = "form-row">
              <label for = "subRouteDesc">Description</label>
              <textarea class = "form-control" maxlength = "250" rows = "3" id = "routeDesc" name = "routeDesc" placeholder="Please provide a short description (optional)..."></textarea>
            </div>
            <div class = "form-row" style = "margin-top:10px;">
				<div class="col text-center">
				  <button class = "btn btn-success btn-lg" type = "submit" style = "width:40%;" id = "addRoute">SUBMIT</button>
				</div>
			</div>
          </form>
        </div>
      </div>
    </div>
  </body>

  <script type="text/javascript">
      var colourChosen;
      $("#subForm").submit(function(event){

        var route = draw.getAll();
        var myJson = JSON.stringify(route);
        var parse = JSON.parse(myJson);

        //alert (colourChosen)


        if(parse.features[0] == null){
          alert ('It appers that you have not plotted a route on the map. Please try again.');
        } else if (colourChosen == null){
          alert('Please choose a colour using the colour picker supplied.');
        } else {

          var index = parse.features.length - 1;
          var coordArray = parse.features[index].geometry.coordinates;
          var startPArray = coordArray[0];
          var start = "";
          startPArray.forEach(function(sp){
            start += sp + ",";
          });
          
          var coordinates = "";

          coordArray.forEach(function(coord){
            coordinates += coord + "&";
          });

          var rrCoordinates = coordinates.replace(/.$/,"");
          
          var rrName = $('#routeName').val();
          var rrDesc = $('#routeDesc').val();
          var rrLength = rrDM + ' miles (' + rrDKM + 'km)';
          var rrColour = colourChosen;
          var rrStartP = start;
          $.ajax({
            url: 'rrsubInsert.php',
            method:'POST',
            async:false,
            data:{rrCoordinates:rrCoordinates, rrName : rrName, rrDesc : rrDesc, rrLength : rrLength, rrColour: rrColour, rrStartP:rrStartP},
            success: function(msg){
              alert(msg);
              window.location.href = "index.php";

            }

          });
        }
        event.preventDefault();
        
      });

      $(".colourPicker").spectrum({
        color: "#f00",
        change: function(color) {
            $("#colConfirmation").text("Colour Chosen");
            colourChosen = color.toHexString();
        }
      });
  </script>

  <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoidzZnNzAiLCJhIjoiY2pubmJsYjVrMWtpZDNwbDd6d3g2bTU2dSJ9.wRg7VWUkYrd666fGGinxoQ';
    /* eslint-disable */
    var bounds = [
    [-2.299434658112034, 52.97709880504107], // Southwest Coordinates
    [-2.1969133279259836, 53.02390126537867]  // Northeast Coordinates
    ];
    var map = new mapboxgl.Map({
      container: 'map', // container id
      style: 'mapbox://styles/w6g70/cjseez4rl0b3t1fqlve1lj3oe', //hosted style id
      center: [-2.2721905868837666, 53.00318967082782], // starting position
      zoom: 15, // starting zoom
      maxBounds: bounds
    });

    /* Add Map Load */
    map.on('load', function loadAddMap(){
      var fixButton = document.getElementById('resizeAddMap');
      /* Location Adding Map Fix Button */
      fixButton.onclick = function() {
         map.resize();
      }
      /* ============================== */
    });
    /* ============ */

    var draw = new MapboxDraw({
      displayControlsDefault: false,
      controls: {
        line_string: true,
        trash: true
      }
    });

    map.addControl(draw);

    map.on('draw.create', updateArea);
    map.on('draw.delete', updateArea);
    map.on('draw.update', updateArea);
    
    var rrDM = 0;
    var rrDKM = 0;

    function updateArea(e) {
      var data = draw.getAll();
      var answer = document.getElementById('calculated-area');
      if (data.features.length > 0) {
        var miles = turf.lineDistance(data, 'miles');
        rrDM = Math.round(miles*100)/100;
        var km = turf.lineDistance(data, 'kilometers');
        rrDKM = Math.round(km*100)/100;
      } else {
        if (e.type !== 'draw.delete') alert("Use the draw tools to draw a polygon!");
      }
    }
  </script>

</html>
