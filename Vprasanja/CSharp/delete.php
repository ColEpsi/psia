<?php
include("config.php");
session_start();
if (!isset($_SESSION['logged_on'])) {
  header("location: index.php");
  die();
}
$id = $_SESSION['session_id'];
mysqli_query($db, "DELETE FROM data_csharp WHERE ID='$id'");

header("location:admin.php");
?>
