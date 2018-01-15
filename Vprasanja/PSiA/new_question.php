<?php
include("config.php");
session_start();
if (!isset($_SESSION['logged_on'])) {
  header("location: index.php");
  die();
}

if (isset($_POST['submit'])) {
    $mytitle    = mysqli_real_escape_string($db, $_POST['title']);
    $myquestion = mysqli_real_escape_string($db, $_POST['question']);
    $myanswer   = mysqli_real_escape_string($db, $_POST['answer']);
    $mykeywords = mysqli_real_escape_string($db, $_POST['keywords']);
    $mysources = mysqli_real_escape_string($db, $_POST['sources']);
    $mycomment = mysqli_real_escape_string($db, $_POST['comment']);
    $mykeywords = ucwords(strtolower($mykeywords), " ,");

    $return_string = '<h4><strong>Vprašanje:</strong></h4><p>'.$myquestion.'</p><h4><strong>Ključne besede:</strong> <span style="font-size: 14px;">'.$mykeywords.'</span></h4><h4><strong>Vir:&nbsp;</strong><a style="font-size: 14px;" target="_blank" href="'.$mysources.'">'.$mysources.'</a></h4><h4><strong>Odgovor:</strong></h4><p>'.$myanswer.'</p><h4><strong>Dodatne opombe:</strong></h4><p>'.$mycomment.'</p>';


    $upload_ID  = "0";

    if (isset($_FILES['userfile']) && $_FILES["userfile"]["size"] > 0 ) {
        $fileName = $_FILES['userfile']['name'];
        $tmpName  = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];



        $fp      = fopen($tmpName, 'r');
        $content = fread($fp, filesize($tmpName));
        $content = addslashes($content);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileName = addslashes($fileName);
        }
        $query = "INSERT INTO upload (name, size, type, content )
        VALUES ('$fileName', '$fileSize', '$fileType', '$content')";

        mysqli_query($db, $query);

        $upload_ID = mysqli_fetch_assoc(mysqli_query($db, "SELECT id FROM upload WHERE name='$fileName'"));
        $upload_ID = $upload_ID['id'];
    }



    $userID = $_SESSION['ID'];
    $sql = "INSERT INTO data (contributor_ID, question, answer, tag, upload_ID) VALUES ('$userID', '$mytitle', '$return_string','$mykeywords', '$upload_ID')";

    mysqli_query($db, $sql) or die(mysqli_error($db));
    header("location:logged_in.php");

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

		<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="tinymce/init-tinymce.js"></script>
    <script src="../ckeditor/ckeditor.js"></script>
    <script src="../ckfinder/ckfinder.js"></script>
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Podatkovne strukture in algoritmi</title>
</head>
<body>
	<div class="container">
		<nav class="navbar sticky-topa navbar-inverse">
			<div class="container-fluid">
			<a class="navbar-brand" href="logged_in.php">Nazaj</a>
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
			<h1>Vprašanja in odgovori iz Podatkovnih struktur in algoritmov</h1>
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
   			<label for="title">Naslov vprašanja <i>(slovenščina):</i></label>
  		<input type="text" class="form-control" id="title" name="title"  value="" required>
   		</div>

	</div>
	<div class="form-group">
   		<div class="col-sm-12">
   			<label for="question">Vprašanje:</label>
  		<input type="text" class="form-control" id="quesion" name="question"  value="" required>
   		</div>

	</div>
	<br>
	<div class="form-group" >
  <div class="col-sm-12">
        <label for="question">Ključne besede <i>(z veliko začetnico in ločene z vejicami):</i></label>
      <input type="text" class="form-control" id="keywords" name="keywords"  value="" required>
      </div>
  </div>
	<div class="form-group">
   		<div class="col-sm-12">
   			<label for="question">Vir:</label>
  		<input type="text" class="form-control" id="sources" name="sources"  value="">
   		</div>

	</div>
   	<div class="form-group">
   		<div class="col-sm-12">
   			<label for="answer">Odgovor:</label>
  		<textarea class="form-control" rows="5" id="answer" name="answer"></textarea>
      <script type="text/javascript">
        var editor = CKEDITOR.replace( 'answer' );
        CKFinder.setupCKEditor( editor );
      </script>
   		</div>

	</div>
	<div class="form-group">
   		<div class="col-sm-12">
   			<label for="comment">Dodatne opombe:</label>
  		<input type="text" class="form-control" id="comment" name="comment"  value="">
   		</div>

	</div>

   	<div  class="form-group">
   	<div class="col-sm-12">
   		<br>

		<input id="userfile" type="file" class="file" name="userfile">
		</div>
	</div>
      <br>
      <div style="text-align:center; " class="button">
        <button class="btn btn-primary btn-lg" type="submit" name="submit">Oddaj vprašanje</button>
      </div>
    </form>
    </div>

    </div>
		</div>

	</div><!-- Content will go here -->
</body>
</html>
