<?php
include("config.php");
session_start();
if (!isset($_SESSION['logged_on'])) {
  header("location: index.php");
  die();
}
if (!isset($_SESSION['logged_admin'])) {
  header("location: logged_in.php");
  die();
}

$id = intval($_GET['id']);

$delete_location = 'delete.php?id='.$id;

$content = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM data_csharp WHERE ID='$id'"));

//echo "<script>console.log(".$id.");</script>";
if (isset($_POST['submit'])) {
    $myquestion = mysqli_real_escape_string($db, $_POST['question']);
    $myanswer   = mysqli_real_escape_string($db, $_POST['answer']);
    $mykeywords = mysqli_real_escape_string($db, $_POST['keywords']);
    $mykeywords = ucwords(strtolower($mykeywords), " ,");
    $verified = 0;
    if (isset($_POST['verified'])) {
        $verified = 1;
    }
    $upload_ID  = $content['upload_ID'];
    if (isset($_FILES['userfile'])  && $_FILES["userfile"]["size"] > 0 ) {
        $fileName = $_FILES['userfile']['name'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        echo "<script>alert(".$fileName.")</script>";
        $fp      = fopen($tmpName, 'r');
        $data = fread($fp, filesize($tmpName));
        $data = addslashes($data);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileName = addslashes($fileName);
        }

        $query = "INSERT INTO upload_csharp (name, size, type, content )
        VALUES ('$fileName', '$fileSize', '$fileType', '$data')";

        mysqli_query($db, $query);

        $upload_ID = mysqli_fetch_assoc(mysqli_query($db, "SELECT id FROM upload_csharp WHERE name='$fileName'"));
        $upload_ID = $upload_ID['id'];
    }
    $sql = "UPDATE data_csharp SET question='$myquestion', answer='$myanswer', verified='$verified', tag='$mykeywords', upload_ID='$upload_ID' WHERE ID='$id'";
    mysqli_query($db, $sql) or die(mysqli_error($db));
    header("location:admin.php");

}

$message     = "";
$credentials = $_SESSION['credentials'];


?>
<html>
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
  <link rel="shortcut icon" type="image/png" href="FMF_favicon.png"/>
	<link href="https://www.w3schools.com/w3css/3/w3.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

    <script src="../ckeditor/ckeditor.js"></script>
    <script src="../ckfinder/ckfinder.js"></script>
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Programski jezik C#</title>
</head>
<body>
	<div class="container">
		<nav class="navbar sticky-topa navbar-inverse">
			<div class="container-fluid">
			<a class="navbar-brand" href="logged_in.php">Začetna stran</a>
              <a class="navbar-brand" href="javascript:history.back()">Nazaj</a>
				<ul class="nav fixed-top navbar-nav navbar-right">

					<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><span class="glyphicon glyphicon-user"></span> <?php echo $credentials; ?></b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
											 <button onclick="window.location.href='logout.php'" type="submit" name="submit" class="btn btn-danger btn-block">Odjava</button>
												<br>


							</div>
					 </div>
				</li>
			</ul>
        </li>
				</ul>
			</div>
		</nav>
		<div class="container-fluid" style="background-color: white;">
			<h1>Vprašanja in odgovori iz programskega jezika C#</h1>
		<h4>Fakulteta za matematiko in fiziko, Univerza v Ljubljani</h4>
		<hr>
				<div class="container-fluid" style="background-color: white">
			    <div >
    <br>
    <div class="forminput" style="text-align:  center; object-position: center;">
    	<div style="text-align:center;color:red;font-style:oblique">
      <?php echo $message; ?>
    </div>
    <br>
    <form class="form-horizontal" id="form-input" role="form" method="post" enctype="multipart/form-data" action="">
      <div class="form-group">
   		<div class="col-sm-12">
   			<label for="question">Naslov vprašanja:</label>
  		<input type="text" class="form-control" id="quesion" name="question"  value="<?php echo $content['question']; ?>">
   		</div>

	</div>
   	<div class="form-group">
   		<div class="col-sm-12">
  		<textarea class="form-control" rows="5" id="answer" name="answer"><?php echo $content['answer'];?></textarea>
        <script type="text/javascript">
          var editor = CKEDITOR.replace( 'answer' );
          CKFinder.setupCKEditor( editor );
        </script>
   		</div>

	</div>
      <br>
      <div class="form-group" >
  <div class="col-sm-12">
      <label for="question">Ključne besede:</label>
      <input type="text" class="form-control" id="keywords" name="keywords"  value="<?php echo $content['tag']; ?>">
      </div>
</div>
<div  class="form-group">
<div class="col-sm-12">
<br>
<input id="userfile" type="file" class="file" name="userfile">
</div>
</div>
    <label class="custom-control custom-checkbox">
  <input type="checkbox" name="verified" id="verified" class="custom-control-input" checked>
  <span class="custom-control-indicator"></span>
  <span class="custom-control-description">Označi objavo kot preverjeno</span>
</label>
      <div style="text-align:center; " class="button">
        <button class="btn btn-primary btn-lg" type="submit" name="submit">Posodobi</button>
        <button type="button" class="btn btn-lg btn-danger" onclick="window.location.href='<?php echo $delete_location; ?>'">Izbriši objavo</button>
      </div>
    </form>

    </div>

    </div>
		</div>

	</div><!-- Content will go here -->
</body>
</html>
