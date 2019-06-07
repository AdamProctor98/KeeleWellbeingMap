<?php
  /*Checks if admin is logged in if access through URL is attempted*/
  session_start();
  if(!isset($_SESSION['loggedin'])) header("Location: index.php");
	if($_SESSION['loggedin']===FALSE) header("Location: index.php");
?>
<html>
<head>
  <title>Keele Wellbeing Map - Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.css' rel='stylesheet' />
  <link rel="stylesheet" type = "text/css" href="styles/adminStyle.css"/>
</head>

<body>
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
      <h1 class="display-5">Locations on the Map,</h1>
      <p class="lead">Here you can manipulate locations shown on the map currently and ones awaiting for approval:</p>
      <hr class="my-4">
      <a class="btn btn-primary" href="adminIndex.php" role="button">Reurn to Admin Options</a>
    </div>
  </div>
  <!------>

  <!--Sub Navigation Bar - Pills -->
  <div id = "navPills" class = "container">
    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
      <!-- View Database -->
      <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-view" role="tab" aria-controls="pills-home" aria-selected="true">View Database</a>
      </li>
      <!------>
      <!-- Add New Location -->
      <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-add" role="tab" aria-controls="pills-profile" aria-selected="false">Add New Location</a>
      </li>
      <!------>
      <!-- Delete A Location -->
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-delete" role="tab" aria-controls="pills-contact" aria-selected="false">Delete a Location</a>
      </li>
      <!------>
      <!-- Submitted Locations -->
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-contact" aria-selected="false">Approve Submitted Locations</a>
      </li>
      <!------>
    </ul>

    <!-- Content of each Pill -->
    <div id = "pillsContent" class = "container">
      <div class="tab-content" id="pills-tabContent">

        <!-- Database View Pill Content -->
        <div class="tab-pane fade show active" id="pills-view" role="tabpanel" aria-labelledby="pills-view-tab">
          <br>
          <h4>All of the current location currently plotted on the map are listed below:</h4>
          <div class = "card" id = "viewCard">
            <div class = "container" style = "margin-top:15px;">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                    </div>
                    <input type="text" id="locationTitle" onkeyup="locTableFilterTitle()" placeholder="Search table by the Title of the location..." class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                  </div>

            </div>

            <div class = "card-body" id = "viewCardBody" name = "viewCardBody" >
              <div id = "viewDB"></div>
            </div>
          </div>
        </div>
        <!------>

        <!-- Add New Location Pill Content -->
        <div class="tab-pane fade" id="pills-add" role="tabpanel" aria-labelledby="pills-add-tab">
          <br>
          <div class = "container">
          <div class = "card" style = "margin-bottom: 50px;">
            <div class = "card-body" name = "addCardBody">
              <h4>Please complete the form below to add a new Location:</h4>
              <!-- New Location Form -->
              <form id = "addLocForm">
                <div class = "form-row">
                  <!-- Location Title -->
                  <div class = "form-group col-md-6">
                    <label for="inputTitle">Title:</label>
                    <input type:"text" class="form-control" id = "inputTitle" name="inputTitle" placeholder="Please enter title..." required maxlength="25">
                  </div>
                  <!------>
                  <!-- Location Category -->
                  <div class = "form-group col-md-6">
                    <label for="selectCategory">Category:</label>
                    <select name = "selectCategory" id = "selectCategory" class = "form-control" required>
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
                  <!------>
                </div>

                <div class = "form-group">
                  <!-- Location Coordinates -->
                  <label for="addMap">Click and Drag the marker to the location: <button id='resizeAddMap' type='button' class="btn btn-primary">Enlarge Map</button>
                  <input name="longitude" id="longitude" type = "hidden" value = "">
                  <input name="latitude" id="latitude" type = "hidden" value = ""></label>
                  <!-- Movable Marker Map -->
                  <div id='addMap'></div>
                  <!------>
                  <!--<strong>Draggable Pointer Coordinates:</strong>-->
                  <div class = "form-row">
                    <div id = "markerPlaced" name = "markerPlaced"></div>
                  </div>
                  <!------>
                </div>
                <div class = "form-group">
                  <!-- Location Description -->
                  <label for = "inputDescription">Description:</label>
                  <textarea class = "form-control" rows="3" name = "inputDescription" id = "inputDescription" placeholder="Please provide a description if applicable..."></textarea>
                  <!------>
                </div>
                <br>
                <div class="form-row">
                  <!-- Submit Button
                   * When Clicked: Form contents are sent to adminAddLoc.php -->
                  <div class="col text-center">
                    <button class="btn btn-success btn-lg adminButton" type = "submit">Submit</button>
                  </div>
                  <!------>
                </div>

              </form>
            </div>
          </div>
        </div>
        </div>
        <!------>

        <!-- Delete Location Pill Content -->
        <div class="tab-pane fade" id="pills-delete" role="tabpanel" aria-labelledby="pills-delete-tab">
          <br>
          <div class = "card">
            <div class = "card-body" name = "deleteCardBody">
              <h4>Please choose the location you wish to delete using the dropdown box:</h4>
              <!-- Delete Location form
                * Contains a select box which is pre-filled with all the locations currently on the map using adminDelLocView.php
                * When submitted: The selected option is sent to adminDelLoc.php
              -->

                  <div id = "delLocation"></div>
              <!------>
            </div>
          </div>
        </div>
        <!------>

        <!-- Submitted locations Pill Contents-->
        <div class="tab-pane fade" id="pills-approve" role="tabpanel" aria-labelledby="pills-approve-tab">
          <br>
          <div class = "card">
            <div class = "card-body" name = "approveCardBody">
              <h4>Listed below are all the entries submitted: 
                <!-- Fix Map button
                  *Used to resize the map if not spamming the page properly
                -->
                <button id='resizeSubMap' type='button' class="btn btn-primary">Enlarge map</button>
              </h4>
              <br>

              <!-- Submission Map -->
              <div id = 'subMap'></div>
              
              <!------>
              
                <!-- Contains the submissions made -->
                <div class = "card" id = "lsubmissionCard">
                  <div class = "card-body" name = "subCard" id = "subCard">
                  </div>
                </div>
                <!------>
                
               
                
              
            </div>
          </div>
        </div>
        <!------>

      </div>
    </div>
  <!----->
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
          <form id = "deleteLocationForm">
            <div class="modal-body">


                  <h5>Please confirm you wish to delete the following location:</h5>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Number</span>
                      </div>
                      <input type="text" class="form-control" name = "locationDelID" id = "locationDelID" readonly>
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Details</span>
                      </div>
                      <input type="text" class="form-control" name = "locationDelDetails" id = "locationDelDetails" readonly>
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
      var table = 1;
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
    
  </script>
  <!-- Delete Location -->
  <script>
    /* Used to pre-populate select input for Delete Location Pill */
    $(document).ready(function locDelView(){
      $.ajax({
          url: 'adminDelLocView.php',
          async: false,
          success: function(data) {
              $('#delLocation').empty();
              $('#delLocation').append(data)
          }
      });
    });
    /* ========================================================= */

    $('#delModal').on('show.bs.modal', function (e) {
      var locationOptionText = $("#locationDelSelect option:selected").text();
      var locationID = $("#locationDelSelect option:selected").val();
      $("#locationDelID").val(locationID);
      $("#locationDelDetails").val(locationOptionText);
    });

    $( "#deleteLocationForm" ).submit(function(event) {
      var locationDelete = $('#locationDelID').val();
      
      $.ajax({
        url : 'adminDelLoc.php',
        type : 'POST',
        async: false,
        data: {locationDelete : locationDelete},
        success: function(msg){
          alert (msg);
          location = location;
        }
      });


    });
  </script>
  <!------>
  <!-- Add Location -->
  <script>
    $( "#addLocForm" ).submit(function(event) {
      var locTitle = $('#inputTitle').val();
      var locCategory = $('#selectCategory').val();
      var locLong = $('#longitude').val();
      var locLat = $('#latitude').val();
      var locDescription = $('#inputDescription').val();

      if (locLong === "" || locLat === ""){
        document.getElementById('markerPlaced').innerHTML = "<strong style = 'color:red;'>Location has not been chosen!</strong>";
      } else {
        $.ajax({
          url : 'adminAddLoc.php',
          type : 'POST',
          async: false,
          data: {locTitle : locTitle, locCategory : locCategory, locDescription : locDescription,
          locLong : locLong, locLat: locLat},
          success: function(msg){
            alert (msg);
            location = location;
          }
        });
      }
      event.preventDefault();
    });
  </script>
  <!------>

  <script>
    /* Called when the user wishes to delete a submission */
    function delLoc(id){
      var subID = id;
      $.ajax({
        url :'adminLSubDel.php',
        type: 'POST',
        async: false,
        data: {subID : subID},
        success: function(msg){
          alert(msg);
          location = location;
        }
      });
    }
    /* ================================================== */
    /* Used to Deisplay a form for each submission made */
    $(document).ready(function subView(){
      $.ajax({
        url :'adminLSubView.php',
        async: false,
        success: function(data){
          $('#subCard').empty();
          $('#subCard').append(data)
        }
      });
    });
    /* ================================================= */
    /* Used to filter the database table using the Title */
    function locTableFilterTitle() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("locationTitle");
      filter = input.value.toUpperCase();
      table = document.getElementById("locationTable");
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
    mapboxgl.accessToken = 'pk.eyJ1IjoidzZnNzAiLCJhIjoiY2pubmJuenlyMDBucTN3bzFmeGh0Y2F5ZiJ9.bbEJovAXpADYG62sxMd-cQ'; //Access key
    var longitude = document.getElementById('longitude');
    var latitude = document.getElementById('latitude');
    var addMap = new mapboxgl.Map({
      container: 'addMap', // container id for Add Location Map
      style: 'mapbox://styles/w6g70/cjseez4rl0b3t1fqlve1lj3oe', // style of map used (Custom)
      center: [-2.2739505947879763,53.00266947632235], // starting position [lng, lat]
      zoom: 15, // starting zoom
      minZoom: 15 //minimum zoom
    });
    /* Add Map Load */
    addMap.on('load', function loadAddMap(){
      var fixButton = document.getElementById('resizeAddMap');
      /* Location Adding Map Fix Button */
      fixButton.onclick = function() {
         addMap.resize();
      }
      /* ============================== */
    });
    /* ============ */
    /* Draggable Marker for New Location Map */
      var marker = new mapboxgl.Marker({
          draggable: true
      })
          .setLngLat([-2.2739505947879763,53.00266947632235]) //starting position of marker
          .addTo(addMap);
      /* Displaying Coordinates when dragging marker */
      function onDragEnd() {
          var lngLat = marker.getLngLat();
          longitude.value = lngLat.lng
          latitude.value = lngLat.lat;
          document.getElementById('markerPlaced').innerHTML = "<strong>Location has been chosen!</strong>";
      }
      /* =========================================== */

    marker.on('dragend', onDragEnd);
    /* ====================================== */


    /* =================== */
    /* Submissions Map */
    /* =================== */
    var subMap = new mapboxgl.Map({
      container: 'subMap', // container id
      style: 'mapbox://styles/w6g70/cjseez4rl0b3t1fqlve1lj3oe', // style of submission map (Custom)
      center: [-2.2739505947879763,53.00266947632235], // starting position [lng, lat]
      zoom: 15, // starting zoom
    });

    var subs; //contains JSON with submissions
    /* Retrieves Submission from adminSubMap.php */
    $(document).ready(function retrieveSubs() {
  		$.ajax({
  			url: 'adminLSubMap.php',
  			dataType: "json",
  			success: function(geojson) {
  				subs = geojson;
  			}
  		});
  	});
    /* ========================================= */
    /* Submission Map Load */
    subMap.on('load', function loadSubMap() {
      var fixButton = document.getElementById('resizeSubMap'); //Fix Buttons
      /* Add Submissions to Map */
      /* Fix Button */
      fixButton.onclick = function fixMap() {
        subMap.resize();
      }
      /* ========== */
      subMap.addSource("subs", {
                    "type": "geojson",
                    "data": subs
                    });
      /* ====================== */
      
        subs.features.forEach(function addSubLoc(feature){
        var symbol = feature.properties['icon'];
        var layerID = 'poi-' + symbol;

        // Adds a layer for this symbol type if it hasn't been added already
        if (!subMap.getLayer(layerID)) {
          // Adding Layer
          subMap.addLayer({
                       "id": layerID,
                       "type": "symbol",
                       "layout": {
                       "icon-image": symbol,
                       "icon-allow-overlap": true
                       },

                       "source": "subs",
                       "filter": ["==", "icon", symbol]
                       });
                       var popup = new mapboxgl.Popup({
                                                      closeButton: false,
                                                      closeOnClick: false
                                                      });
                      /* Hover Over: Pop-up Setup */
                       subMap.on('mouseenter', layerID, function displaySubPopup(e) {
                              // Change the cursor style as a UI indicator.
                              subMap.getCanvas().style.cursor = 'pointer';

                              var coordinates = e.features[0].geometry.coordinates.slice();
                              var description = e.features[0].properties.description;

                              // Ensure that if the map is zoomed out such that multiple
                              // copies of the feature are visible, the popup appears
                              // over the copy being pointed to.
                              while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                              coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                              }

                              // Populate the pop-up and set its coordinates
                              // based on the feature found.
                              popup.setLngLat(coordinates)
                              .setHTML(description)
                              .addTo(subMap);
                              });

                       subMap.on('mouseleave', layerID, function removeSubPopup() {
                              subMap.getCanvas().style.cursor = '';
                              popup.remove();
                              });

                       }
                   /* =========================== */

        });
      
     
      /* Iterates through each submission */
      

     
   });

   /* Zoom Controls for each map */
    var addNav = new mapboxgl.NavigationControl({showCompass:false, showZoom:true});
    var subNav = new mapboxgl.NavigationControl({showCompass:false, showZoom:true});
    subMap.addControl(subNav, 'top-left');
    addMap.addControl(addNav, 'top-left');
  /* =========================== */

  /* ====================================================================== */
  </script>
</body>
</html>
