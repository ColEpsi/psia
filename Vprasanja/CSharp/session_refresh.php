<?php
  session_start();
  if (isset($_SESSION['ID'])) {
   $_SESSION['ID'] = $_SESSION['ID'];
   $_SESSION['credentials'] = $_SESSION['credentials'];
   $_SESSION['logged_on'] = $_SESSION['logged_on'];
  }

 ?>
