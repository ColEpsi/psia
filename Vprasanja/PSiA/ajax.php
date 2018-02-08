<?php
include("config.php");
session_start();

$id = intval($_GET['q']);
$query = "SELECT * FROM data WHERE ID = '$id'"; //expecting one row
$result = mysqli_query($db, $query);
$message = mysqli_fetch_assoc($result);
$question = $message['question'];
$answer = $message['answer']; //expecting just on row
$contributor_ID = $message['contributor_ID'];
$upload_ID = $message['upload_ID'];
if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	$active_user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE (email = '$username' or username = '$username')"));
	$active_name = $active_user['name'];
	$active_surname = $active_user['surname'];
	$active_admin = $active_user['permission_level'];
}
else{
	$active_name = "none";
	$active_surname = "none";
	$active_admin = 0;
}


$credentials = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE ID = '$contributor_ID'"));
$name = $credentials['name'];
$surname = $credentials['surname'];
$file = "";
$sql = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM upload WHERE id = '$upload_ID'"));
$file_size = $sql['size'];
if($file_size > 0){
	$file = '<a href="download.php?id='.$upload_ID.'>">'.$sql['name'].'</a>';
}
$locationuser = 'edit_user.php?id='.$id;
$locationadmin = 'edit_admin.php?id='.$id;
$location_user = "'".$locationuser."'";
$location_admin = "'".$locationadmin."'";

if($active_name == $name && $active_surname == $surname && $active_admin == 2){
	$response = '<button type="button" class="pull-right btn btn-warning" target="_blank" onclick="window.location.href='.$location_admin.'">Uredi objavo</button><h3><strong>'.$question.'</strong></h3><p>'.$answer.'</p>'.$file.'<p class="pull-right"><br><i>Prenesel uporabnik: <strong>'.$name.' '.$surname.'</strong></i><br></p>';
}
else if($active_name == $name && $active_surname == $surname){
	$response = '<button type="button" class="pull-right btn btn-warning" target="_blank" onclick="window.location.href='.$location_user.'">Uredi objavo</button><h3><strong>'.$question.'</strong></h3><p>'.$answer.'</p>'.$file.'<p class="pull-right"><br><i>Prenesel uporabnik: <strong>'.$name.' '.$surname.'</strong></i><br></p>';
}
else if($active_admin == 2){
	$response = '<button type="button" class="pull-right btn btn-warning" onclick="window.location.href='.$location_admin.'">Uredi objavo</button><h3><strong>'.$question.'</strong></h3><p>'.$answer.'</p>'.$file.'<p class="pull-right"><br><i>Prenesel uporabnik: <strong>'.$name.' '.$surname.'</strong></i><br></p>';
}
else{
	$response = '<h3><strong>'.$question.'</strong></h3><p>'.$answer.'</p>'.$file.'<p class="pull-right"><br><i>Prenesel uporabnik: <strong>'.$name.' '.$surname.'</strong></i><br></p>';
}


echo $response;
?>
