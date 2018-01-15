<?php
include("config.php");
session_start();

unset($_SESSION['logged_on'])
header("location: index.php");
?>
