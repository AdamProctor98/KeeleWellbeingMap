<?php
  /*Checks if admin is logged in if access through URL is attempted*/
  session_start();
  if(!isset($_SESSION['loggedin'])) header("Location: index.php");
	if($_SESSION['loggedin']===FALSE) header("Location: index.php");
?>
<html>
<head>
  <title>Run Route: Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.css' rel='stylesheet' />
  <link rel="stylesheet" type = "text/css" href="styles/adminStyle.css"/>
  
  <!-- Colour Picker: Provided by Spectrum -->

  <script src='spectrum.js'></script>
  <link rel='stylesheet' href='styles/spectrum.css' />

</head>

<style>
	#addmap {width:100%; height: 400px;}
	#submap {width:100%; height: 400px;}
</style>

<body>

<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css' type='text/css'/>
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js'></script>



  <!---Navighation bar--->
  <nav id = "adminNav" class="navbar navbar-light">
    <a class="navbar-brand" href="#">
      <img src="media/KeeleUni-WHITE.png" alt="Keele Univeristy Logo" height="42" width="86">
    </a>
    <!--Logout Button-->
    <form method = "POST" action = "logout.php">
      <button type="submit" class="btn btn-primary" style="position:relative;float:right;margin-top:10px;" >Logout</button>
    </form>
  </nav>
  <!------>

  <!-- Jumbotron -->
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-5">Welcome Admin,</h1>
      <p class="lead">Here you can manipulate Run Routes shown on the map currently and ones awaiting for approval:</p>
      <hr class="my-4">
      <a class="btn btn-primary" href="adminIndex.php" role="button">Reurn to Admin Options</a>
    </div>
  </div>
  <!------>

  <!--Sub Navigation Bar - Pills -->
  <div id = "navPills" class = "container">
    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
      <!-- View Routes -->
      <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-view" role="tab" aria-controls="pills-home" aria-selected="true">View Run Routes</a>
      </li>
      <!------>
      <!-- Add New Route -->
      <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-add" role="tab" aria-controls="pills-profile" aria-selected="false">Add New Route</a>
      </li>
      <!------>
      <!-- Delete A Route -->
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-delete" role="tab" aria-controls="pills-contact" aria-selected="false">Delete a Route</a>
      </li>
      <!------>
      <!-- Submitted Routes -->
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-contact" aria-selected="false">Approve Submitted Routes</a>
      </li>
      <!------>
    </ul>

    <!-- Content of each Pill -->
    <div id = "pillsContent" class = "container">
      <div class="tab-content" id="pills-tabContent">

        <!-- Database View Pill Content -->
        <div class="tab-pane fade show active" id="pills-view" role="tabpanel" aria-labelledby="pills-view-tab">
          <br>
          <div class = "card">
            <div class = "card-body" id = "viewCardBody" name = "viewCardBody" >
				<h4>All of the current routes currently plotted on the map are listed below:</h4>
				<div class = "container" style = "margin-top:15px;">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroup-sizing-default">Name</span>
						</div>
						<input type="text" id="runrouteName" onkeyup="rrTableFilterName()" placeholder="Search table by the Name of the run route..." class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
					</div>

				</div>
				<div id = "viewDB"></div>
            </div>
          </div>
        </div>
        <!------>
        <!-- Add New Route Pill Content -->
        <div class="tab-pane fade" id="pills-add" role="tabpanel" aria-labelledby="pills-add-tab">
          <br>
          <div class = "container-fluid">
          <div class = "card" style = "margin-bottom: 50px;">
            <div class = "card-body" name = "addCardBody">
              <h4>Please complete the form below to add a new run route:</h4>
              <!-- New route Form -->
              <form id = "addForm">
                <div class = "form-row form-group">
                  <div class = "col-md-9">
                    <label for = "routeName">Name</label>
                    <input class = "form-control" id = "routeName" name = "routeName" placeholder = "Please enter the name of the route..." required>
                  </div>
                  <div class = "col-md-3">
                    <label for = "routeCol">Colour</label><br>
                    <input type="text" class="colourPicker" id = "routeCol" name = "routeCol">
                    <em id = "colConfirmation">Colour not chosen</em>
                  </div>
                </div>

                <div class = "form-row form-group">
                  <label for = "addmap">Plot run route <button type = "button" class = "btn btn-primary" id = "resizeAddMap">Resize Map</button><br><small>Click the button in the top left corner of the map to begin
                  plotting your run route. Once you have plotted the last point for the route, please click that point again to finalise the route. If
                  you wish to start again, select the run you have just plotted with your mouse and select the delete button (Bin) in the top left corner.
                  Please be aware that if you draw more than one route on the map, only the first route drawn will be submitted.</small></label>
                  <div id='addmap'></div>

                </div>
                <div class = "form-row">
                  <label for = "subRouteDesc">Description</label>
                  <textarea class = "form-control" maxlength = "250" rows = "3" id = "routeDesc" name = "routeDesc" placeholder="Please provide a short description (optional)..."></textarea>
                </div>
                <div class = "form-row" style = "margin-top:10px;">
				<div class="col text-center">
                  <button class = "btn btn-success btn-lg" style = "width:40%;" type = "submit" id = "addRoute">SUBMIT</button>
				  </div>
                </div>
          </form>
            </div>
          </div>
        </div>
      </div>
      <!------>
      <!-- Delete Route Pill Content -->
      <div class="tab-pane fade" id="pills-delete" role="tabpanel" aria-labelledby="pills-delete-tab">
        <br>
        <div class = "card">
          <div class = "card-body" name = "deleteCardBody">
            <h4>Please choose the run route you wish to delete using the dropdown box:</h4>
            <!-- Delete Route form
              * Contains a select box which is pre-filled with all the routes currently on the map using adminDelRouteView.php
              * When submitted: The selected option is sent to adminDelRoute.php
            -->
           
                <div id = "delRoute"></div>
             
            <!------>
          </div>
        </div>
      </div>
      <!------>
      <!-- Submitted Routes Pill Contents-->
      <div class="tab-pane fade" id="pills-approve" role="tabpanel" aria-labelledby="pills-approve-tab">
        <br>
        <div class = "card">
          <div class = "card-body" name = "approveCardBody">
            <h4>Listed below are all the routes submitted: <!-- Fix Map button
                  *Used to resize the map if not spamming the page properly
                -->
                <button id='resizeSubMap' type='button' class="btn btn-primary">Resize Map</button></h4>
            <br>
            <div class="row">
              
              <!-- Submission Map -->
                <div id = 'submap'></div>
              <!------>
            </div>
            <div name = "rrSubCard" id = "rrSubCard">
            </div>
            
          </div>
        </div>
      </div>
      <!------>
      
      <!------>
	</div>
  </div>
  <!----->
  </div>
  <!------>

  <!-- Delete Modal -->
  <div class="modal" id="delModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form id = "deleteRRForm">
          <div class="modal-body">

            <h5>Please confirm you wish to delete the following location:</h5>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Number</span>
              </div>
              <input type="text" class="form-control" name = "rrDelID" id = "rrDelID" readonly>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Details</span>
              </div>
              <input type="text" class="form-control" name = "rrDelDetails" id = "rrDelDetails" readonly>
            </div>

          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type = "submit" class="btn btn-success">Yes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!------>
  <script>

  /* Used to get contents of tabkle for View Database Pill*/
  $(document).ready(function viewDatabase(){
    var table = 3;
    $.ajax({

        url: 'adminViewTable.php',
        type : 'POST',
        async: false,
        data: {table:table},
        success: function(data) {
            $('#viewDB').empty();
            $('#viewDB').append(data)
        }
    });
  });
  /* ==================================================== */

  /* Used to pre-populate select input for Delete Location Pill */
    $(document).ready(function locDelView(){
      $.ajax({
          url: 'adminDelRRView.php',
          async: false,
          success: function(data) {
              $('#delRoute').empty();
              $('#delRoute').append(data)
          }
      });
    });
  /* ========================================================= */
</script>
<script>
   $('#delModal').on('show.bs.modal', function (e) {
      var rrOptionText = $("#rrDelSelect option:selected").text();
      var rrID = $("#rrDelSelect option:selected").val();
      $("#rrDelID").val(rrID);
      $("#rrDelDetails").val(rrOptionText);
    });

    $( "#deleteRRForm" ).submit(function(event) {
      var rrDelete = $('#rrDelID').val();
      
      $.ajax({
        url : 'adminDelRR.php',
        type : 'POST',
        async: false,
        data: {rrDelete : rrDelete},
        success: function(msg){
          alert (msg);
          location = location;
        }
      });


    });
</script>
<script>
  /* Used to get contents of tabkle for View Database Pill*/
  $(document).ready(function(){
		var colourChosen;
      $("#addForm").submit(function(event){

      var route = draw.getAll();
      var myJson = JSON.stringify(route);
      var parse = JSON.parse(myJson);
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
          url: 'adminAddRoute.php',
          method:'POST',
          async:false,
          data:{rrCoordinates:rrCoordinates, rrName : rrName, rrDesc : rrDesc, rrLength : rrLength, rrColour: rrColour, rrStartP:rrStartP},
          success: function(msg){
            location = location;

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
	});
</script>

<script>
	function rrTableFilterName() {
	  // Declare variables
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById("runrouteName");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("runrouteTable");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
		  txtValue = td.textContent || td.innerText;
		  if (txtValue.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
		  } else {
			tr[i].style.display = "none";
		  }
		}
	  }
	}
</script>

<script>

  /* =================== */
  /* Maps for Admin Page */
  /* =================== */
    mapboxgl.accessToken = 'pk.eyJ1IjoidzZnNzAiLCJhIjoiY2pubmJsYjVrMWtpZDNwbDd6d3g2bTU2dSJ9.wRg7VWUkYrd666fGGinxoQ';
  /* eslint-disable */
  var bounds = [
  [-2.299434658112034, 52.97709880504107], // Southwest Coordinates
  [-2.1969133279259836, 53.02390126537867]  // Northeast Coordinates
  ];
  var addmap = new mapboxgl.Map({
    container: 'addmap', // container id
    style: 'mapbox://styles/w6g70/cjseez4rl0b3t1fqlve1lj3oe', //hosted style id
    center: [-2.2721905868837666, 53.00318967082782], // starting position
    zoom: 15, // starting zoom
    maxBounds: bounds
  });

  /* Add Map Load */
  addmap.on('load', function loadAddMap(){
    var fixButton = document.getElementById('resizeAddMap');
    /* Location Adding Map Fix Button */
    fixButton.onclick = function() {
       addmap.resize();
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

  addmap.addControl(draw);

  addmap.on('draw.create', updateArea);
  addmap.on('draw.delete', updateArea);
  addmap.on('draw.update', updateArea);
  
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
      // restrict to area to 2 decimal points
    } else {
      if (e.type !== 'draw.delete') alert("Use the draw tools to draw a polygon!");
    }
  }


  /* =================== */
  /* Submissions Map */
  /* =================== */
  var submap = new mapboxgl.Map({
    container: 'submap', // container id
    style: 'mapbox://styles/w6g70/cjseez4rl0b3t1fqlve1lj3oe', // style of submission map (Custom)
    center: [-2.2739505947879763,53.00266947632235], // starting position [lng, lat]
    zoom: 15, // starting zoom
    maxBounds:bounds
  });

  var routes; //contains JSON with submissions
  /* Retrieves Submission from adminSubMap.php */
  $(document).ready(function retrieveSubRoutes() {
    $.ajax({
      url: 'adminRRSubMapRoutes.php',
      dataType: "json",
      success: function(geojson) {
        routes = geojson;
      }
    });
  });
  var routeInfo; //contains JSON with submissions
  /* Retrieves Submission from adminSubMap.php */
  $(document).ready(function retrieveSubRoutesInfo() {
    $.ajax({
      url: 'adminRRSubMapInfo.php',
      dataType: "json",
      success: function(geojson) {
        routeInfo = geojson;
      }
    });
  });
  /* ========================================= */
  /* Submission Map Load */
  submap.on('load', function loadSubMap() {
    var fixButton = document.getElementById('resizeSubMap'); //Fix Buttons
    /* Add Submissions to Map */
    /* Fix Button */
    fixButton.onclick = function fixMap() {
      submap.resize();
    }
    submap.addSource("routes",{
      "type": "geojson",
      "data": routes
    });


    routes.features.forEach(function addLoc(feature){
      var layerID = feature.properties['icon'];

        // Add a layer for this symbol type if it hasn't been added already.

      if (!submap.getLayer(layerID)) {
        submap.addLayer({
          "id": layerID,
          "type": "line",
          "source": "routes",
          "paint": {
            'line-width': 3,
            'line-color': ['get', 'color']
          },
          
        });

   ////////////////////////////////////////////////////////////////////
      }

    });

    submap.addSource("routeInfo", {
      "type": "geojson",
      "data": routeInfo
    });

    routeInfo.features.forEach(function addLoc(feature){
     var symbol = feature.properties['icon'];
     var layerID = 'poi-' + symbol;
     var layerLabel = feature.properties['name'];

         // Add a layer for this symbol type if it hasn't been added already.

         if (!submap.getLayer(layerID)) {
           submap.addLayer({
            "id": layerID,
            "type": "symbol",
            "layout": {
              "icon-image": symbol,
              "icon-allow-overlap": true
            },

            "source": "routeInfo",
          });

         ////////////////////////////////////////////////////////////////////

        submap.on('click', layerID, function displayPopup(e) {
              // Change the cursor style as a UI indicator.
              submap.getCanvas().style.cursor = 'pointer';

              var coordinates = e.features[0].geometry.coordinates.slice();
              var description = e.features[0].properties.description;

              // Ensure that if the map is zoomed out such that multiple
              // copies of the feature are visible, the popup appears
              // over the copy being pointed to.
              while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
              }

              // Populate the popup and set its coordinates
              // based on the feature found.
              new mapboxgl.Popup()
                .setLngLat(coordinates)
                .setHTML(description)
                .addTo(submap);
        });

        submap.on('mouseenter', layerID, function () {
          submap.getCanvas().style.cursor = 'pointer';
        });

        submap.on('mouseleave', layerID, function removePopup() {
          submap.getCanvas().style.cursor = '';
        });
      }

     });
    
   
    /* Iterates through each submission */
    

     
   });
</script>
<script>
    /* Used to Deisplay a form for each submission made */
    $(document).ready(function subView(){
      $.ajax({
        url :'adminRRSubView.php',
        async: false,
        success: function(data){
          $('#rrSubCard').empty();
          $('#rrSubCard').append(data)
        }
      });
    });
    /* ================================================ */
</script>
<script>
    /* Called when the user wishes to delete a submission */
    function delRoute(id){
      var subID = id;
      $.ajax({
        url :'adminRRSubDel.php',
        type: 'POST',
        async: false,
        data: {subID : subID},
        success: function(data){
          alert('Operation successful. Submission Deleted.');
          location = location;
        }
      });
    }
    /* ================================================== */
  </script>
</body>
</html>
