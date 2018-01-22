<?php
if(isset($_GET['id']))
{
include("config.php");
session_start();
if (!isset($_SESSION['logged_on'])) {
  header("location: index.php");
  die();
}

$id    = $_GET['id'];
$query = "SELECT name, type, size, content FROM upload WHERE id = '$id'";


$result = mysqli_query($db, $query) or die('Error, query failed');
list($name, $type, $size, $content) =                                  mysqli_fetch_array($result);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;

include 'library/closedb.php';
exit;
}

?>
