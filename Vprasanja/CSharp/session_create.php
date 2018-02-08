<?php
session_start();

if (isset($_GET['session_name'])) {
	$location = "location:edit.php?id=".$_GET['session_name'];
	header($location);
}
?>
