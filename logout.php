<?php
  session_start();
  session_destroy();
  $_SESSION['loggedin']=FALSE;
  header("Location: index.php");
  exit();
?>
