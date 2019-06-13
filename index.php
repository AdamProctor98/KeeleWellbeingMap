<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="We have recently been focusing more on the
  health and wellbeing of our staff and students. This interactive provides the key information
  relating to our facilities that we can provide to promote this.">
  <meta name="keywords" content="Keele Wellbeing, Wellbeing Map, Keele Map,
  Interactive Wellbeing Map, Keele Interactive Map, Keele Health and Wellbeing">

  <title>Keele Wellbeing Map</title>

  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" type = "text/css" href="styles/style.css"/>
  <!-- Font Awesome JS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <!-- jQuery CDN - Slim version (=without AJAX) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <!-- AJAX -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Popper.JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <!-- MapBox GL JS -->
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />

</head>

<body>
	<div class="contentManager">

		<!------------------------------------------------------------------------>
		<!------------------------------ Sidebar  -------------------------------->
		<!------------------------------------------------------------------------>

		<nav id="sidebar">
		  <div class="sidebar-header">
			<a href = "https://www.keele.ac.uk/healthandwellbeing/knowledgebank/wellbeing/"><span><img src = "media/KeeleUni-WHITE.png" alt = "Keele Logo White" height="82"></span></a>
		  </div>
		  <div class = "sidebar-subheader">
			<h4>Events</h4>
		  </div>

		  <div id = "newsEventCard">
			<div class="card eventCard" >
			  <div class="card-body" id="eventView"></div>
			</div>
		  </div>

		  <div id = "addEventDiv" class = "row">
			<a role = "button" class = "btn btn-primary" href = "eventSubmission.php"><span><i class="fas fa-calendar-alt"></i></span> Add Event</a>
		  </div>

		</nav>

		<!------------------------------------------------------------------------>
		<!--------------------------- Page Contents  ----------------------------->
		<!------------------------------------------------------------------------>

		<div id="content">
			<!-- Navigation Bar -->
			<nav class="navbar navbar-light " id = "topNav">

				<div id = "topNavOptions">
					<button type="button" id="sidebarCollapse" class="btn btn-primary" id = "eventSideBtn" title = "Toggle Event's Panel">
						<i class="fas fa-align-left"></i><span> Events</span>
					</button>

					<button type = "button" class = "btn btn-primary" data-toggle="modal" data-target="#infoModal" id = "infoBtn" title = "More Information">
						<i class="fas fa-info-circle"></i><span> Information</span>
					</button>
				</div>
				
				<div id = "topNavLogin">
					<button type="button" title = "Admin Login" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
						<i class="fa fa-user"></i>
						<span>Login</span>
					</button>
				</div>

			</nav>

			<!-- Map -->
			<div id = 'map'></div>
			<!---->
			
			<!-- Map Controls -->
			<div id = "mapOptions">
				<button type="button" title = "Filter" class="btn btn-secondary filterBtn" data-toggle="modal" data-target="#filter"><span><i class="fas fa-sliders-h"></i></span></button>
				<a role = "button" title = "Submit New Location" class = "btn btn-secondary lsubBtn" href="locSubmission.php"><span><i class="fas fa-map-marked-alt"></i></span></a>
				<button type = "button" title = "Resize Map" class = "btn btn-secondary fixBtn" id = "resizeMap"><span><i class="fas fa-wrench"></i></span></button>
				<a role = "button" title = "Submit New Run Route" class = "btn btn-secondary rrsubBtn" href = "rrSubmission.php"><span><i class="fas fa-running"></i></span></a>
			</div>
			<!---->

		</div>

	</div>
	<!------------------------------------------------------------------------>
	<!------------------------- Filter Options Modal ------------------------->
	<!------------------------------------------------------------------------>
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="filter" aria-hidden="true" id="filter">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel" >Map Filter:</h4>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  </div>
		  <div class="modal-body">
			<div class = "row">
			  <div class = "col-sm-6"><h5>Locations</h5><nav id="locFilter-group" class="filter-group"></nav></div>

			  <div class = "col-sm-6"><h5>Run Routes</h5><nav id="rrFilter-group" class="filter-group"></nav></div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<!------------------------------------------------------------------------>
	<!---------------------- General Information Modal ----------------------->
	<!------------------------------------------------------------------------>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="informationModal" aria-hidden="true" id = "infoModal">
	  <div class="modal-dialog ">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel" >Keele Wellbeing Map</h4>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			
		  </div>
		  <div class="modal-body">
			<p>At Keele University your health and wellbeing is a priority of ours
			and we want staff and students to feel that they are a valued
			member of the community. This map will help you to keep
			active, take time out, eat well, connect and be supported during
			your time at Keele.<br/><br/><strong>Information relating to each category can be found below:</strong></p><hr>
			<div class = "row container-fluid">
			  <div class="nav flex-column nav-pills col-sm-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				<a class="nav-link beActivePill active" id="v-pills-beActive-tab" data-toggle="pill" href="#v-pills-beActive" role="tab" aria-controls="v-pills-beActive" aria-selected="true">Be Active <img src = "media/BeActive.png" alt = "Be Active Icon" height = "30"></a>
				<a class="nav-link takeTimeOutPill" id="v-pills-takeTimeOut-tab" data-toggle="pill" href="#v-pills-takeTimeOut" role="tab" aria-controls="v-pills-takeTimeOut" aria-selected="false">Take Time Out <img src = "media/TakeTimeOut.png" alt = "Take Time Out Icon" height = "30"></a>
				<a class="nav-link eatWellPill" id="v-pills-eatWell-tab" data-toggle="pill" href="#v-pills-eatWell" role="tab" aria-controls="v-pills-eatWell" aria-selected="false">Eat Well <img src = "media/EatWell.png" alt = "Eat Well Icon" height = "30"></a>
				<a class="nav-link connectPill" id="v-pills-connect-tab" data-toggle="pill" href="#v-pills-connect" role="tab" aria-controls="v-pills-connect" aria-selected="false">Connect <img src = "media/Connect.png" alt = "Connect Icon" height = "30"></a>
				<a class="nav-link beSupportedPill" id="v-pills-beSupported-tab" data-toggle="pill" href="#v-pills-beSupported" role="tab" aria-controls="v-pills-beSupported" aria-selected="false">Be Supported <img src = "media/BeSupported.png" alt = "Be Supported Icon" height = "30"></a>
				<a class="nav-link runRoutePill" id="v-pills-runRoute-tab" data-toggle="pill" href="#v-pills-runRoute" role="tab" aria-controls="v-pills-runRoute" aria-selected="false">Run Routes <img src = "media/RunRoute.png" alt = "Run Route Icon" height = "30"></a>
			  </div>
			  <div class="tab-content col-sm-8" id="v-pills-tabContent">
				<div class="tab-pane fade show active" id="v-pills-beActive" role="tabpanel" aria-labelledby="v-pills-beActive-tab">
				  <p>Did you know? Students and staff can swim at Jubilee 2 for £2 a go. Just take your Keele card along with you to get this deal.
					<br/><br/>The Keele Sports Centre has a wide range of facilities for you to make the most of during your time at Keele including a
					bouldering wall, full sized 3G football pitch, and four recently refurbished tennis courts. If you take out our annual gym
					membership, you also get the BUCS UNIversal membership. This means when you're at home, you can use your local university gym
					for free!
					<br/><br/>Fancy cycling to Keele? Find out where you can locate lockers, cycle storage and cycle washing facilities on campus by
				  searching for the ‘Keele Cycle Map’.</p>
				</div>
				<div class="tab-pane fade" id="v-pills-takeTimeOut" role="tabpanel" aria-labelledby="v-pills-takeTimeOut-tab">
				  <p>Why not take a wander up to the observatory to have a viewing of the night sky and meet an astronomer?
					<br/><br/>At the Chapel you’ll find a full-time Chaplaincy team who serve staff and students of all faiths
					and none, and a variety of student Christian groups. If you want to talk to one of the Chaplains then
					just pop in and say hi during the day.
					<br/><br/>Fancy venturing off campus? Give something different a go with Laser Quest or escape rooms available
					just a five-minute drive away at Lymelight Boulevard. Catch a show at the Regent Theatre or get your adrenaline
				  pumping with a trip to Alton Towers.</p>
				</div>
				<div class="tab-pane fade" id="v-pills-eatWell" role="tabpanel" aria-labelledby="v-pills-eatWell-tab">
				  <p>We have a fantastic Farmers’ Market where you’ll find fresh fruit and vegetables, pies, homemade bread
					and homemade scotch eggs! You can find this every Tuesday (during term time) outside the Students’ Union.
					<br/><br/>Visit Chancellor’s Bistro where you can grab homemade sandwiches, salads and smoothies. On The Square
					offers a wide range of delicious lunch options from jacket potatoes and salad boxes, to chicken dishes and Asian
					food. Visit the SU with Munch for hot meals, jacket potatoes, salads and sandwiches with gluten free, vegetarian
					and vegan options. Or visit the Union shop for daily meal deals.
					<br/><br/>Did you know? Every Wednesday in the Refectory, there is a vegan hot dish on the menu. We call it
				  Vegan Wednesday.</p>
				</div>
				<div class="tab-pane fade" id="v-pills-connect" role="tabpanel" aria-labelledby="v-pills-connect-tab">
				  <p>There are hundreds of societies on campus that you can join so why not take a look at what’s on offer and
					connect with people with similar interests.
					<br/><br/>Fancy volunteering your time to help others? Become a storyteller at a children’s hospital, walk rescue
					dogs at the Greyhound Gap or work at a local charity shop. Find out more about opportunities at the
					<a href="https://keelesu.com/activities/volunteering/"><em>KeeleSU Volunteering webpages.</em></a>
					<br/><br/>Socialise at one of the many events available to you on campus from live music gigs, karaoke, pub quizzes
				  and pool competitions.</p>
				</div>
				<div class="tab-pane fade" id="v-pills-beSupported" role="tabpanel" aria-labelledby="v-pills-beSupported-tab">
				  <p>Have concerns or a query? Need some support and guidance? Make the most of the services available on and off campus.
					<br/><br/><strong>At Keele</strong>
					<br/>Keele Student Services | 01782 734481 | <a href="mailto: student.services@keele.ac.uk">student.services@keele.ac.uk</a>
					<br/>Keele Counselling and Mental Health | 01782 734187 | <a href="mailto: counselling@keele.ac.uk">counselling@keele.ac.uk</a>
					<br/>Advice and Support at Keele (ASK) | <a href="mailto: su.ask@keele.ac.uk">su.ask@keele.ac.uk</a>
					<br/>Staff Counselling | 01782 733733 | <a href="mailto: occupationalhealth.enquiries@keele.ac.uk">occupationalhealth.enquiries@keele.ac.uk</a>
					<br/><br/><strong style = "color:#735365">Other</strong>
					<br/>Silvercloud | Offers free online solutions which deliver space from anxiety, depression, stress, eating issues & chronic illness Mind | 0300 123 3393 | Here to
				  make sure anyone with a mental health problem has somewhere to turn for advice and support</p>
				</div>
				<div class="tab-pane fade" id="v-pills-runRoute" role="tabpanel" aria-labelledby="v-pills-runRoute-tab">
				  <p>Whether you want a lunchtime walk or looking to kickstart your fitness, our walk/run routes are here for you. With easy to follow routes from 1-12kms, there's something for everyone. Walk, jog or run the routes at your pace, and with many starting from the halls of residence, there's little excuse not to get out there and get active!<br/><br/>Fun fact: If you add all the routes together, it becomes the length of a marathon! How long will it take you to complete yours?<br/><br/>You do have the ability to suggest new routes for the wellbeing map, using the 'Add Run Route' option on the map. The list below shows the routes available on the map:</p>
				  <ul>
					<li>Barnes Run/Walk Routes</li>
					<li>Holly Cross & Oaks Run/Walk Routes</li>
					<li>Horwood Run/Walk Routes</li>
					<li>Lindsay Run/Walk Routes</li>
					<li>Forest of Light Run/Walk Routes</li>
					<li>Original Run/Walk Routes
					  <ul>
						<li>1, 2, 3, and 5k</li>
					  </ul>
					</li>
				  </ul>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<!------------------------------------------------------------------------>
	<!---------------------------- Login Modal  ------------------------------>
	<!------------------------------------------------------------------------>
	<form id = "loginForm">
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
			
				<div class="modal-content">
					<div class="modal-header" style="text-align:center;">
						<h5 class="modal-title" id="loginModalLabel" >Admin Login</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div style = "text-align:center;"><img src="media/KeeleUni-RGB_Colour.png" alt = "Keele Logo Colour" height="82"></div>
						
						<div class = "form-group">
							<label for="username">Username</label>
							<input type="text" id="username" name = "username" class="form-control" placeholder="Please enter your username..." required autofocus>
						</div>

						<div class = "form-group">
							<label for="password">Password</label>
							<input type="password" id="password" name="password" class="form-control" placeholder="Please enter your password..." required>
						</div>
					</div>

					<div class="modal-footer" >
						<div class="container">
							<div class="row">
								<div class="col text-center">
									<button type="submit" class="btn btn-success text-center" style="width:40%;" >Login</button>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</form>
	<!------------------------------------------------------------------------>
	<!------------------------------------------------------------------------>
	<!------------------------------------------------------------------------>

	<!-- Load Events on load -->
	<script>
	  $(document).ready(function eventView(){
		$.ajax({
		  url: 'mapEventView.php',
		  async: false,
		  success: function(data) {
			$('#eventView').empty();
			$('#eventView').append(data);
		  }
		});
	  });
	</script>
	<!------>

	<!-- Login Function -->
	<script>
	  $( "#loginForm" ).submit(function(event) {
			var username = $('#username').val();
			var password = $('#password').val();

			$.ajax({
				url: 'login.php',
				method:'POST',
				async:false,
				data:{username:username,password:password},
				success: function(msg){
					if (msg == "true"){
						alert ('You have successfully logged in!');
						event.preventDefault();
						window.location.href = "adminIndex.php";
						return false;
					} else if (msg == "false"){
						event.preventDefault();
						alert ('Login unsuccessful');
					}
				}

			});

		  });
	</script>
	<!------>

	<!-- Fly To Event -->
	<script>
		function flyToLoc(long, lat){
			map.flyTo({
			  center: [long,lat],
			  zoom:20,
			  curve: 0.5
			});

			var eventLoc = [long,lat];

			// create the popup
			var eventPopup = new mapboxgl.Popup({ offset: 25 })
			.setText("This is the location of the event");

			//create DOM element for the marker
			var el = document.createElement('div');
			el.id = 'eventMarker';

			// create the marker
			new mapboxgl.Marker(el)
			.setLngLat(eventLoc)
			.setPopup(eventPopup) // sets a popup on this marker
			.addTo(map);
		}
	</script>
	<!----->
	
	<!-- Wellbeing Map -->
	<script src="wellbeingMap.js"></script>
	<!----->
	
	<!-- Sidebar Collapse -->
	<script type="text/javascript">
		$(document).ready(function sidebarCollapse() {
			$('#sidebarCollapse').on('click', function () {
				$('#sidebar').toggleClass('active');
			});
		});
	</script>
	<!------>

</body>

</html>
