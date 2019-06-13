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
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  
</head>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<body>
  <!---Navighation bar--->
  <nav id = "adminNav" class="navbar navbar-light">
    <a class="navbar-brand" href="#">
      <img src="media/KeeleUni-WHITE.png" alt="Keele Univeristy Logo" height="42">
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
      <h1 class="display-5">Events on the Map,</h1>
      <p class="lead">Here you can manipulate Events shown on the map currently and ones awaiting for approval:</p>
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
      <!-- Add New Event -->
      <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-add" role="tab" aria-controls="pills-profile" aria-selected="false">Add New Event</a>
      </li>
      <!------>
      <!-- Delete A Event -->
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-delete" role="tab" aria-controls="pills-contact" aria-selected="false">Delete an Event</a>
      </li>
      <!------>
      <!-- Submitted Events -->
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-contact" aria-selected="false">Approve Events Submitted</a>
      </li>
      <!------>
    </ul>

  <!-- Content of each Pill -->
  <div id = "pillsContent" class = "container">
    <div class="tab-content" id="pills-tabContent">

      <!-- Database View Pill Content -->
      <div class="tab-pane fade show active" id="pills-view" role="tabpanel" aria-labelledby="pills-view-tab">
        <br>
        <h4>All of the events currently shown on the map are listed below:</h4>
        <div class = "card" id = "viewCard">
          <div class = "container" style = "margin-top:15px;">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
              </div>
              <input type="text" id="eventTitle" onkeyup="eventTableFilterTitle()" placeholder="Search table by the Title of the event..." class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
          </div>

          <div class = "card-body" id = "viewCardBody" name = "viewCardBody" >
            <div id = "viewDB"></div>
          </div>
        </div>
      </div>
      <!------>

      <!-- Add New Evenbt Pill Content -->
      <div class="tab-pane fade" id="pills-add" role="tabpanel" aria-labelledby="pills-add-tab">
        <br>
        <div class = "container">
        <div class = "card" style = "margin-bottom: 50px;">
          <div class = "card-body" name = "addCardBody">
            <h4>Please complete the form below to add a new event:</h4>
            <!-- New Event Form -->
            <form id = "addEventForm">
            <div class = "form-row">
                <!-- Event Title -->
                <div class = "form-group col-md-6">
                  <label for="addeventTitle">Title:</label>
                  <input type="text" class="form-control" name="addeventTitle" id = "addeventTitle" placeholder="Please enter title..." required maxlength="100" required>
                </div>
                <!------>
                <div class = "form-group col-md-6">
                      <!-- Event Location -->
                      <label for = "addeventloc">Location:</label>
                      <div id = "addeventLoc"></div>
                      <!------>
                  </div>
                
              </div>

              <div class = "form-row">
                  <!-- Event Time From -->
                <div class = "col-md-6">
                  <label for = "addeventTimeFrom">Time From:</label>
                    <input id = "addeventTimeFrom" name = "addeventTimeFrom"class="timepicker text-center custom-select" jt-timepicker="" time="model.time" time-string="model.timeString" default-time="model.options.defaultTime" time-format="model.options.timeFormat" start-time="model.options.startTime" min-time="model.options.minTime" max-time="model.options.maxTime" interval="model.options.interval" dynamic="model.options.dynamic" scrollbar="model.options.scrollbar" dropdown="model.options.dropdown" required>
                  
                </div>
                  <!-- Event Time To -->
                  <div class = "col-md-6">
                  <label for = "addeventTimeTo">Time To:</label>
                   <input id = "addeventTimeTo" name = "addeventTimeTo"class="timepicker text-center custom-select" jt-timepicker="" time="model.time" time-string="model.timeString" default-time="model.options.defaultTime" time-format="model.options.timeFormat" start-time="model.options.startTime" min-time="model.options.minTime" max-time="model.options.maxTime" interval="model.options.interval" dynamic="model.options.dynamic" scrollbar="model.options.scrollbar" dropdown="model.options.dropdown" required> 
                  
                </div>
              </div>
              <!-- Event Date -->
                <div class = "form-row">
                  <label for="addeventDate">Date:</label>
                  <input type="date" class = "form-control" placeholder = "yyyy-mm-dd" pattern = "([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))" id="addeventDate" name="addeventDate" required/>
                </div>
                <!------>

              <div class = "form-row">
                <!-- Event Description -->
                <label for="addeventDescription">Decription:</label>
                <textarea rows="3" class = "form-control" id = "addeventDescription" name = "addeventDescription" placeholder="Please provide a description ..." required></textarea>
                <!------>
              </div>

              
              <br>
              <div class="form-row">
                <div class="col text-center">
                  <button class="btn btn-success btn-lg adminButton" type = "submit">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
      </div>
      <!------>

      <!-- Delete EVent Pill Content -->
      <div class="tab-pane fade" id="pills-delete" role="tabpanel" aria-labelledby="pills-delete-tab">
        <br>
        <div class = "card">
          <div class = "card-body" name = "deleteCardBody">
            <h4>Please choose the event you wish to delete using the dropdown box below:</h4>
            <!-- Delete Event form
              * Contains a select box which is pre-filled with all the locations currently on the map using adminEventDelSelect.php
              * When submitted: The selected option is sent to adminDelEvent.php
            -->
              <div id = "delEvent"></div>
            <!------>
          </div>
        </div>
      </div>
      <!------>

      <!-- Submitted Events Pill Contents-->
      <div class="tab-pane fade" id="pills-approve" role="tabpanel" aria-labelledby="pills-approve-tab">
        <br>
        <div class = "card">
          <div class = "card-body" name = "approveCardBody">
            <h4>Listed below are all the entries submitted:</h4>
            <br>
            
              <!-- Contains the submissions made -->
              <div id = "esubCard">
                <div class = "card" id = "esubmissionCard">
                  <div class = "card-body" name = "esubCard" id = "esubCard">
                  </div>
                </div>
              
              <!------>
             
              </div>
          </div>
        </div>
      </div>
      <!------>

    </div>
  </div>
  <!----->

  </div>

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
          <form id = "deleteEventForm">
            <div class="modal-body">


                  <h5>Please confirm you wish to delete the following event:</h5>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Number</span>
                      </div>
                      <input type="text" class="form-control" name = "eventDelID" id = "eventDelID" readonly>
                    </div>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Details</span>
                      </div>
                      <input type="text" class="form-control" name = "eventDelDetails" id = "eventDelDetails" readonly>
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
    /* Used to get contents of table for View Database Pill*/
    $(document).ready(function viewDatabase(){
      var table = 2;
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
    /* =================================================== */
    /* Used to filter the database table using the Title */
    function eventTableFilterTitle() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("eventTable");
      filter = input.value.toUpperCase();
      table = document.getElementById("eventTable");
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
    /* ==================================================== */
  </script>

  <script>
    $(document).ready(function eventLocSelect(){
      $.ajax({
          url: 'adminEventLocSelect.php',
          async: false,
          success: function(data) {
              $('#addeventLoc').empty();
              $('#addeventLoc').append(data)
          }
      });
    });

    $( "#addEventForm" ).submit(function(event) {

      var eventTitle = $('#addeventTitle').val();
      var eventLocation = $('#addeventLocSelect').val();
      var eventTimeFrom = $('#addeventTimeFrom').val();
      var eventTimeTo = $('#addeventTimeTo').val();
      var eventDate = $('#addeventDate').val();
      var eventDescription = $('#addeventDescription').val();


      $.ajax({
        url : 'adminAddEvent.php',
        type : 'POST',
        async: false,
        data: {eventTitle : eventTitle, eventLocation : eventLocation, eventDescription : eventDescription,eventTimeFrom: eventTimeFrom, eventTimeTo: eventTimeTo, eventDate:eventDate},
        success: function(msg){
          alert (msg);
          location=location
        }
      });

      event.preventDefault();
    });
  </script>
  <script>
    /* Used to pre-populate select input for Delete event Pill */
    $(document).ready(function locDelView(){
      $.ajax({
          url: 'adminDelEventView.php',
          async: false,
          success: function(data) {
              $('#delEvent').empty();
              $('#delEvent').append(data)
          }
      });
    });
    /* ========================================================= */

     $('#delModal').on('show.bs.modal', function (e) {
      var eventOptionText = $("#eventDelSelect option:selected").text();
      var eventID = $("#eventDelSelect option:selected").val();
      $("#eventDelID").val(eventID);
      $("#eventDelDetails").val(eventOptionText);
    })

    $( "#deleteEventForm" ).submit(function(event) {
      var eventDelete = $('#eventDelID').val();

      $.ajax({
        url : 'adminDelEvent.php',
        type : 'POST',
        async: false,
        data: {eventDelete : eventDelete},
        success: function(msg){
          alert (msg);
          //location=location
		  document.location.reload(true)
        }
      });

      event.preventDefault();

    });
  </script>

  <script>

    /* Called when the user wishes to delete a submission */
    function delEvent(id){
      var subID = id;
      $.ajax({
        url :'adminESubDel.php',
        type: 'POST',
        async: false,
        data: {subID : subID},
        success: function(data){
          alert('Operation successful. Submission Deleted.');
          document.location.reload(true)
        }
      });
    }
    /* ================================================== */
    /* Used to Deisplay a form for each submission made */
    $(document).ready(function subView(){
      $.ajax({
        url :'adminESubView.php',
        async: false,
        success: function(data){
          $('#esubCard').empty();
          $('#esubCard').append(data)
        }
      });
    });
    /* ================================================= */
    /* Called when an event submitted is to be approved */

    /* ================================================ */
    

    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        minTime: '10',
        maxTime: '11:00pm',
        defaultTime: '10',
        startTime: '09:00',
        dynamic: false,
        dropdown: true,
        scrollbar: false
    });

  </script>
</body>
</html>
