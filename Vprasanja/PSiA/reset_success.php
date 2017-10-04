<?php
   include("config.php");
   session_start();
   $_SESSION['verified'] = 1;
   //$_SESSION['name'] = 0;
   //$_SESSION['surname'] = 0;
   $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $myusername = mysqli_real_escape_string($db,$_POST['uname']);
      $mypassword = mysqli_real_escape_string($db,$_POST['pass']);     
      $sql = "SELECT * FROM users WHERE email = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);  
      $count = mysqli_num_rows($result);
      $_SESSION['username'] = $myusername;
      $_SESSION['password'] = $mypassword;
      
      if($count == 1) {
        header("location: logged_in.php");
      }else {
        $error = "Vaše uporabniško ime ali geslo je nepravilno!"; 
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
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Podatkovne strukture in algoritmi</title>
</head>
<body>
	<div class="container">
		<nav class="navbar sticky-topa navbar-inverse">
			<div class="container-fluid">
				<ul class="nav fixed-top navbar-nav navbar-right">
					<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><span class="glyphicon glyphicon-log-in"></span> Prijava</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
								 <form class="form" method="POST" action="" accept-charset="UTF-8" id="login-nav">
								 		<div style="color:red">
            <?php echo $error?>
            <br>
            <br>
          </div>
										<div class="form-group">
											 <label class="sr-only" for="InputEmail">Email naslov</label>
											 <input type="email" class="form-control" id="InputEmail" placeholder="Email naslov" name="uname" required>
										</div>
										<div class="form-group">
											 <label class="sr-only" for="InputPassword">Geslo</label>
											 <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Geslo" name="pass" required>
                                             <div class="help-block text-right"><a href="password_reset.php">Pozabljeno geslo?</a></div>
										</div>
										<div class="form-group">
											 <button type="submit" name="submit" class="btn btn-primary btn-block">Prijava</button>
										</div>
										
								 </form>
							</div>
							<div class="bottom text-center">
								Nov uporabnik? <a href="register.php"><b>Registracija</b></a>
							</div>
					 </div>
				</li>
			</ul>
        </li>
				</ul>
			</div>
		</nav>
		<div class="container-fluid" style="background-color: white; text-align:center">
			<h2>Zahvaljujemo se vam za poizvedbo.</h2>
		<h3>Na vaš email naslov smo poslali vaše pozabljeno geslo</h3>
		
		
		
	</div><!-- Content will go here -->
</body>
</html>