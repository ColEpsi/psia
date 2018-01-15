<?php
include("config.php");
session_start();
$id = $_SESSION['session_id'];
mysqli_query($db, "DELETE FROM data_csharp WHERE ID='$id'");

header("location:logged_in.php");
?>
