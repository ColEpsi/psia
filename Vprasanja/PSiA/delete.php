<?php
include("config.php");
session_start();
if (!isset($_SESSION['logged_on'])) {
  header("location: index.php");
  die();
}
$id = $_GET['id'];
mysqli_query($db, "DELETE FROM data WHERE ID='$id'");

header("location:admin.php");
?>
