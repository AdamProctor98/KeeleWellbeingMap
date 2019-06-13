mapboxgl.accessToken = 'pk.eyJ1IjoidzZnNzAiLCJhIjoiY2pubmJsYjVrMWtpZDNwbDd6d3g2bTU2dSJ9.wRg7VWUkYrd666fGGinxoQ';

var places;
$(document).ready(function getLocations() {
	$.ajax({
		url: 'placesGeojson.php',
		dataType: "json",
		success: function(geojson) {
			places = geojson;
		}
	});
});


var runRouteInfo;
$(document).ready(function getLocations() {
  $.ajax({
    url: 'rrInfoGeojson.php',
    dataType: "json",
    success: function(geojson) {
      runRouteInfo = geojson;
    }
  });
});

var runRoutes;
$(document).ready(function getLocations() {
  $.ajax({
    url: 'rrRouteGeojson.php',
    dataType: "json",
    success: function(geojson) {
      runRoutes = geojson;
    }
  });
});

var locfilterGroup = document.getElementById('locFilter-group');
var rrfilterGroup = document.getElementById('rrFilter-group');
var bounds = [
  [-2.299434658112034, 52.97709880504107], // Southwest Coordinates
  [-2.1969133279259836, 53.02390126537867]  // Northeast Coordinates
  ];
  var map = new mapboxgl.Map({
                           container: 'map', // container id
                           style: 'mapbox://styles/w6g70/cjseez4rl0b3t1fqlve1lj3oe', // stylesheet location
                           center: [-2.2721905868837666, 53.00318967082782], // starting position [lng, lat]
                           zoom: 15, // starting zoom
                           maxBounds: bounds
                         });


  map.on('load', function loadMap() {
    var fixbutton = document.getElementById('resizeMap');

    /*******************************************Run Routes Trials******************************************/
    map.addSource("runRoutes",{
     "type": "geojson",
     "data": runRoutes
   });


    runRoutes.features.forEach(function addLoc(feature){
      var layerID = feature.properties['icon'];

        // Add a layer for this symbol type if it hasn't been added already.

        if (!map.getLayer(layerID)) {
          map.addLayer({
            "id": layerID,
            "type": "line",
            "source": "runRoutes",
            "paint": {
              'line-width': 3,
              'line-color': ['get', 'color']
            },
            "filter": ["==", "icon", layerID]
          });

            // Add checkbox and label elements for the layer.
            var input = document.createElement('input');
            input.type = 'checkbox';
            input.id = layerID;
            input.checked = false;
            rrfilterGroup.appendChild(input);
            map.setLayoutProperty(layerID,'visibility', 'none');

            var label = document.createElement('label');
            label.setAttribute('for', layerID);
            label.textContent = layerID;
            rrfilterGroup.appendChild(label);

            // When the checkbox changes, update the visibility of the layer.
            input.addEventListener('change', function locVisible(e) {
              map.setLayoutProperty(layerID, 'visibility',
                e.target.checked ? 'visible' : 'none');
            });

     ////////////////////////////////////////////////////////////////////
   }

 });

    /****************************************************************************************************/

    /**********************************************Locations*********************************************/

    // Add a GeoJSON source containing place coordinates and BeSupported.
    map.addSource("places", {
     "type": "geojson",
     "data": places
   });

    places.features.forEach(function addLoc(feature){
     var symbol = feature.properties['icon'];
     var layerID = 'poi-' + symbol;
     var layerLabel = feature.properties['name'];

     // Add a layer for this symbol type if it hasn't been added already.

     if (!map.getLayer(layerID)) {
      map.addLayer({
        "id": layerID,
        "type": "symbol",
        "layout": {
          "icon-image": symbol,
          "icon-allow-overlap": true
        },

        "source": "places",
        "filter": ["==", "icon", symbol]
      });

             // Add checkbox and label elements for the layer.
             var input = document.createElement('input');
             input.type = 'checkbox';
             input.id = layerID;
             input.checked = true;
             locfilterGroup.appendChild(input);

             var label = document.createElement('label');
             label.setAttribute('for', layerID);
             label.textContent = layerLabel;
             locfilterGroup.appendChild(label);

             // When the checkbox changes, update the visibility of the layer.
             input.addEventListener('change', function locVisible(e) {
              map.setLayoutProperty(layerID, 'visibility',
                e.target.checked ? 'visible' : 'none');
            });

         ////////////////////////////////////////////////////////////////////

        map.on('click', layerID, function displayPopup(e) {
              // Change the cursor style as a UI indicator.
              map.getCanvas().style.cursor = 'pointer';

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
                .addTo(map);
        });

        map.on('mouseenter', layerID, function () {
          map.getCanvas().style.cursor = 'pointer';
        });

        map.on('mouseleave', layerID, function removePopup() {
          map.getCanvas().style.cursor = '';
        });


       }

     });
    /****************************************************************************************************/

    /********************************************Run Route Info******************************************/
    map.addSource("runRouteInfo", {
     "type": "geojson",
     "data": runRouteInfo
   });

    runRouteInfo.features.forEach(function addLoc(feature){
     var symbol = feature.properties['icon'];
     var layerID = 'poi-' + symbol;
     var layerLabel = feature.properties['name'];

         // Add a layer for this symbol type if it hasn't been added already.

         if (!map.getLayer(layerID)) {
           map.addLayer({
            "id": layerID,
            "type": "symbol",
            "layout": {
              "icon-image": symbol,
              "icon-allow-overlap": true
            },

            "source": "runRouteInfo",
            "filter": ["==", "icon", symbol]
          });

         // Add checkbox and label elements for the layer.
         var input = document.createElement('input');
         input.type = 'checkbox';
         input.id = layerID;
         input.checked = true;
         rrfilterGroup.appendChild(input);

         var label = document.createElement('label');
         label.setAttribute('for', layerID);
         label.textContent = layerLabel;
         rrfilterGroup.appendChild(label);

         // When the checkbox changes, update the visibility of the layer.
         input.addEventListener('change', function locVisible(e) {
          map.setLayoutProperty(layerID, 'visibility',
            e.target.checked ? 'visible' : 'none');
        });

         ////////////////////////////////////////////////////////////////////

        map.on('click', layerID, function displayPopup(e) {
              // Change the cursor style as a UI indicator.
              map.getCanvas().style.cursor = 'pointer';

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
                .addTo(map);
        });

        map.on('mouseenter', layerID, function () {
          map.getCanvas().style.cursor = 'pointer';
        });

        map.on('mouseleave', layerID, function removePopup() {
          map.getCanvas().style.cursor = '';
        });
      }

     });
    /****************************************************************************************************/

    fixbutton.onclick= function(){
      map.resize();
    }
  });



var nav = new mapboxgl.NavigationControl({showCompass:false, showZoom:true});
var geolocation = new mapboxgl.GeolocateControl({positionOptions: {enableHighAccuracy:true}, trackUserLocation: true});
map.addControl(geolocation, 'top-left');
map.addControl(nav, 'top-left');
