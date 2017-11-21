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
      $mypassword_confirm = mysqli_real_escape_string($db,$_POST['password_confirm']);

     if(strlen($myname) == 0 || strlen($myusername) == 0 || strlen($myemail) == 0 ||
        strlen($myusername) == 0 || strlen($mypassword) == 0){
       $message = "Vnesti morate vsa polja!";
     }
      else if ($mypassword != $mypassword_confirm){
        $message = "Gesli se ne ujemata";
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

   $error = "";
   if(isset($_POST['login'])) {
      $myusername = mysqli_real_escape_string($db,$_POST['uname']);
      $mypassword = mysqli_real_escape_string($db,$_POST['pass']);
      $sql = "SELECT * FROM users WHERE (email = '$myusername' or username = '$myusername')";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      $_SESSION['username'] = $myusername;
      if($count == 1) {
        $sql = "SELECT * FROM users WHERE (email = '$myusername' or username = '$myusername') and password = '$mypassword'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        $_SESSION['password'] = $mypassword;
        if($count == 1) {
          header("location: logged_in.php");
        }
        else {
          $error = "Geslo je napačno!<br><br> <script> dropdown() </script>";
        }
      }else {
        $error = "Uporabnik s tem Email naslovom ali uporabniškim imenom ne obstaja!<br><br> <script> dropdown() </script>";
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
  <script type="text/javascript">
  function dropdown(){
    $('#dropdown').addClass('open');
  }

  </script>
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Programski jezik C#</title>
</head>
<body>
	<div class="container">
		<nav class="navbar fixed-top navbar-inverse">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php">Začetna stran</a>
        <ul class="nav fixed-top navbar-nav navbar-right">
          <li class="dropdown" id="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><span class="glyphicon glyphicon-log-in"></span> Prijava</b> <span class="caret"></span></a>
      <ul id="login-dp" class="dropdown-menu">
        <li>
           <div class="row">
              <div class="col-md-12">
                 <form class="form" method="POST" action="" accept-charset="UTF-8" id="login-nav" >
                    <div style="color:red">
            <?php echo $error?>

          </div>
                    <div class="form-group">
                       <label class="sr-only" for="InputEmail">Email naslov</label>
                       <input type="username" class="form-control" id="InputEmail" placeholder="Email naslov" name="uname" required>
                    </div>
                    <div class="form-group">
                       <label class="sr-only" for="InputPassword">Geslo</label>
                       <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Geslo" name="pass" required>
                                             <div class="help-block text-right"><a href="password_reset.php">Pozabljeno geslo?</a></div>
                    </div>
                    <div class="form-group">
                       <button type="submit" name="login" class="btn btn-primary btn-block" id="prijava">Prijava</button>
                    </div>

                 </form>
              </div>
           </div>
        </li>
      </ul>
        </li>
        </ul>
			</div>
		</nav>
		<div class="container-fluid" style="background-color: white">
			    <div >
    <h2 style="text-align:center">Prosimo, vnesite vaše podatke:</h2>
    <div class="alert alert-info col-centered" role="alert"><strong>Opomba:</strong> Spletni strani Programski jezik C# in Podatkovne strukture in algoritmi uporabljata isto bazo uporabnikov. Če ste se že registrirali v kateri od strani, se prijavite.</div>
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
			<input type="password" class="form-control" id="password" name="password" placeholder="" value="">
		</div>
	</div>
    <div  class="form-group">
		<label for="name" class="col-sm-5 control-label">Potrditev Gesla</label>
		<div class="col-sm-3">
			<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="" value="">
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
