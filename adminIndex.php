<?php
  /*Checks if admin is logged in if access through URL is attempted*/
  session_start();
  if(!isset($_SESSION['loggedin'])) header("Location: index.php");
	if($_SESSION['loggedin']===FALSE) header("Location: index.php");
?>

<html>
<head>
  <title>Keele Wellbeing Map - Admin Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.css' rel='stylesheet' />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
  <link rel="stylesheet" type = "text/css" href="styles/adminStyle.css"/>

</head>

<body>

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
      <p class="lead">Please choose one of the following options to perform a task:</p>
    </div>
  </div>
  <!------>



  <!-- Option Cards -->
  <div class = "container" id = "adminOptions">
    <div class = "row text-center">
      <div class = "col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Location Management</h5>
            <p class="card-text">Add new locations, delete a current location or review a location submitted, awaiting for approval.</p>
            <a href="adminLocation.php" class="btn btn-primary btn-block">Click Here</a>
          </div>
        </div>
      </div>
      <div class = "col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Event Management</h5>
            <p class="card-text">Add new events, delete a current event or review events submitted, awaiting for approval.</p>
            <a href="adminEvent.php" class="btn btn-primary btn-block">Click Here</a>
          </div>
        </div>
      </div>
      <div class = "col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Run Route Management</h5>
            <p class="card-text">Add new run routes, delete a current run route or review any run routes submitted, awaiting for approval.</p>
            <a href="adminRunRoute.php" class="btn btn-primary btn-block">Click Here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!------>

</body>

</html>
