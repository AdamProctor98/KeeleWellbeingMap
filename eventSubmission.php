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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

  </head>
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <body>

    <nav class="navbar navbar-light" style = "background-color: #272548;">
      <a class="navbar-brand" href="#">
        <img src="media/KeeleUni-WHITE.png" alt="Keele University Logo" height="42" width="86">
      </a>
    </nav>
    <div class="jumbotron">
      <div class = "container">
      <h1 class="display-5">Are we missing something?</h1>
      <p class="lead">Filling in this form will allow you to suggest add a new event add to the map. Please be aware that all submissions are reviewed by the
        Sports Centre before being added to the map.</p>
      <hr class="my-4">
      <a class="btn btn-primary btn-lg" href="index.php" role="button">Return To Map</a>
    </div>
    </div>

    <div class="container">
      <div class = "card" style="margin-bottom:50px;">
        <div class = "card-body" name = "addEventCardBody">
          <h4>Event Submission Form:</h4>
          <form id = "subEventForm">
              <div class = "form-row">
                <!-- Event Title -->
                <div class = "form-group col-md-6">
                  <label for="eventTitle">Title:</label>
                  <input type="text" class="form-control" name="eventTitle" id = "eventTitle" placeholder="Please enter title..." required maxlength="100" required>
                </div>
                <!------>
                
                <div class = "form-group col-md-6">
                      <!-- Event Location -->
                      <label for = "eventloc">Location:</label>
                      <div id = "eventLoc"></div>
                      <!------>
                  </div>
              </div>

              <div class = "form-row">
                <!-- Event Time From -->
                <div class = "col-md-6">
                  <label for = "eventTimeF">Time From:</label>
                    <input id = "eventTimeFrom" name = "eventTimeFrom"class="timepicker text-center custom-select" jt-timepicker="" time="model.time" time-string="model.timeString" default-time="model.options.defaultTime" time-format="model.options.timeFormat" start-time="model.options.startTime" min-time="model.options.minTime" max-time="model.options.maxTime" interval="model.options.interval" dynamic="model.options.dynamic" scrollbar="model.options.scrollbar" dropdown="model.options.dropdown" required>
                  
                </div>
                  
                  <!-- Event Time To -->
                  <div class = "col-md-6">
                  <label for = "eventTimeTo">Time To:</label>
                   <input id = "eventTimeTo" name = "eventTimeTo"class="timepicker text-center custom-select" jt-timepicker="" time="model.time" time-string="model.timeString" default-time="model.options.defaultTime" time-format="model.options.timeFormat" start-time="model.options.startTime" min-time="model.options.minTime" max-time="model.options.maxTime" interval="model.options.interval" dynamic="model.options.dynamic" scrollbar="model.options.scrollbar" dropdown="model.options.dropdown" required> 
                  
                </div>
              </div>
              <!-- Event Date -->
				<div class = "form-group form-row">
				  <label for="eventDate">Date:</label>
				  <input type="date" class = "form-control" placeholder = "yyyy-mm-dd" pattern = "([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))" id="eventDate" name="eventDate" required/>
				</div>
				<!------>

              <div class = "form-group form-row">
                <!-- Event Description -->
                <label for="eventDescription">Description:</label>
                <textarea rows="3" class = "form-control" id = "eventDescription" name = "eventDescription" placeholder="Please provide a description ..." required></textarea>
                <!------>
              </div>
              <br>
              <div class="form-row">
                <div class="col text-center">
                  <button class="btn btn-success btn-lg" style = "width:40%;" type = "submit">SUBMIT</button>
                </div>
              </div>

            </form>
        </div>
      </div>
    </div>
  </body>

  <script type="text/javascript">
    $( "#subEventForm" ).submit(function(event) {
      var eventTitle = $('#eventTitle').val();
      var eventLocation = $('#addeventLocSelect').val();
      var eventTimeFrom = $('#eventTimeFrom').val();
      var eventTimeTo = $('#eventTimeTo').val();
      var eventDate = $('#eventDate').val();
      var eventDescription = $('#eventDescription').val();

      
      $.ajax({
        url : 'esubInsert.php',
        type : 'POST',
        async: false,
        data: {eventTitle : eventTitle, eventLocation : eventLocation, eventDescription : eventDescription,
        eventTimeFrom: eventTimeFrom, eventTimeTo: eventTimeTo, eventDate:eventDate},
        success: function(msg){
          alert (msg);
          window.location.href = "index.php";
        }
      });
      //alert(eventDate);
      
      event.preventDefault();
    });

    /* Used to pre-populate select input for a New Event Location */
    $(document).ready(function eventLocSelect(){
      $.ajax({
          url: 'adminEventLocSelect.php',
          async: false, // or GET
          success: function(data) {
              $('#eventLoc').empty();
              $('#eventLoc').append(data)
          }
      });
    });
    /* ======================================================== */

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

</html>
