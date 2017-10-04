<?php
   include("config.php");
   session_start();
    
   $message = "";
   if(isset($_POST['submit']) && $_POST['g-recaptcha-response']!="") {
      //reCAPTCHA
      $secret = '6Lcd3jEUAAAAAGRmFMGmYPwyQZnST2vOY9E26gtt';

      $url = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
      $result = json_decode($url);
      if ($result->success) {
      $myname = mysqli_real_escape_string($db,$_POST['name']);
      $mysurname = mysqli_real_escape_string($db,$_POST['surname']);
      $myemail = mysqli_real_escape_string($db,$_POST['email']);
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
     
     if(strlen($myname) == 0 || strlen($myusername) == 0 || strlen($myemail) == 0 ||
        strlen($myusername) == 0 || strlen($mypassword) == 0){
       $message = "Vnesti morate vsa polja!";
     }
     else{
      $_SESSION['username'] = $myusername;
      $_SESSION['password'] = $mypassword;
       
      $sql_username = "SELECT * FROM users WHERE username = '$myusername'";
      $sql_email = "SELECT * FROM users WHERE email = '$myemail'";
     
      $result_username = mysqli_query($db, $sql_username);
      $result_email = mysqli_query($db, $sql_email);
     
      if(mysqli_num_rows($result_username) >= 1){ 
         $message = "Uporabniško ime že obstaja";
      }
      else if(mysqli_num_rows($result_email) >= 1){
        $message = "Uporabnik s tem E-Mail naslovom že obstaja";
      }
      else {
        $sql = "INSERT INTO users (name, surname, email, username, password) VALUES 
        ('$myname', '$mysurname', '$myemail','$myusername','$mypassword')";
     
        if ($db->query($sql) === TRUE) {
          header("location: index.php");
        } else {
          $message = "Error: " . $sql . "<br>" . $db->error;
        } 
      }
      } 
     }
   }
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
  <link rel="shortcut icon" type="image/png" href="FMF_favicon.png"/>
	<link href="https://www.w3schools.com/w3css/3/w3.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
	</script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Podatkovne strukture in algoritmi</title>
</head>
<body>
	<div class="container">
		<nav class="navbar fixed-top navbar-inverse">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php">Začetna stran</a>
				
			</div>
		</nav>
		<div class="container-fluid" style="background-color: white">
			    <div >
    <h2 style="text-align:center">Prosimo vnesite vaše podatke:</h2> 
    <br>
    <div style="text-align:center;color:red;font-style:oblique">
      <?php echo $message; ?>
    </div>
    <br>
    <form class="form-horizontal" role="form" method="post">
	<div class="form-group">
		<label for="name" class="col-sm-5 control-label">Ime</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="name" name="name" placeholder="" value="">
		</div>
	</div>
   	<div class="form-group">
		<label for="name" class="col-sm-5 control-label">Priimek</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="surname" name="surname" placeholder="" value="">
		</div>
	</div>       
	<div class="form-group">
		<label for="email" class="col-sm-5 control-label">Email</label>
		<div class="col-sm-3">
			<input type="email" class="form-control" id="email" name="email" placeholder="" value="">
		</div>
	</div>
   	<div class="form-group">
		<label for="name" class="col-sm-5 control-label">Uporabniško ime</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="username" name="username" placeholder="" value="">
		</div>
	</div>
   	<div  class="form-group">
		<label for="name" class="col-sm-5 control-label">Geslo</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="password" name="password" placeholder="" value="">
		</div>
	</div> 
      <div>
        <div class="g-recaptcha" style="position: absolute; left: 50%; margin-left: -125px;" data-sitekey="6Lcd3jEUAAAAAAXzL4QGQvYSiEcWzkrzz7P2_4m9"></div>  
      </div>
            
      <br><br><br><br><br><br>
      <div style="text-align:center" class="button">
        <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Registracija">
      </div>
    </form>    
    </div> 
		</div>
		
	</div><!-- Content will go here -->
</body>
</html>
