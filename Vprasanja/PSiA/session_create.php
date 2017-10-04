<?php
session_start();

if (isset($_GET['session_name'])) {
	$_SESSION['session_id'] = $_GET['session_name'];
	header("location:edit.php");
}
?>