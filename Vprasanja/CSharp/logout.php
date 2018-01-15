<?php
include("config.php");
session_start();

unset($_SESSION['logged_on']);
session_destroy();

header("location: index.php");
?>
