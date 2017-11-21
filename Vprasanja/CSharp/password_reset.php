<?php
   include("config.php");
   session_start();

   $message = "";
   if(isset($_SESSION['submit'])) {
      $myemail = mysqli_real_escape_string($db,$_POST['email']);

     if(strlen($myemail) == 0){
       $message = "Prosimo vnesite vaš email naslov!";
     }
     else{
      $sql_email = "SELECT * FROM users WHERE email = '$myemail'";
      $result_email = mysqli_query($db, $sql_email);

      if(mysqli_num_rows($result_email) == 0){
        $message = "Uporabnik s tem E-Mail naslovom ne obstaja!";
      }
      else {
        $result_email = mysqli_fetch_assoc($result_email);
        $password = $result_email['password'];

        $to      = 	$myemail;
		$subject = 'Pozabljeno geslo';
		$message = 'Pozdravljeni,<br>
					vaše pozabljeno geslo je <strong>'.$password.'</strong>. <br>
					Lep pozdrav';
		$headers = 'From: ugi.vaupotic@gmail.com' . "\r\n" .
    			   'Reply-To: ugi.vaupotic@gmail.com' . "\r\n" .
    			   'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

        header("location: reset_success.php");
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
	<script>
		$(document).ready(function(){
    		$('.link').click(function(){
    			var display = '<h2 style="text-align:center">Zahvaljujemo se vam za poizvedbo.</h2><h3 style="text-align:center">Na vaš email naslov smo poslali vaše pozabljeno geslo</h3>';
				document.getElementById("display").innerHTML= display;
   			});
		});

	</script>

	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Programski jezik C#</title>
</head>
<body>
	<div class="container">
		<nav class="navbar fixed-top navbar-inverse">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php">Začetna stran</a>

			</div>
		</nav>
		<div class="container-fluid" id="display" style="background-color: white">
			    <div >
    <h2 style="text-align:center">Prosimo vnesite vaš email naslov:</h2>
    <br>
    <div style="text-align:center;color:red;font-style:oblique">
      <?php echo $message; ?>
    </div>
    <br>
    <form class="form-horizontal" role="form" method="post" action="">      
	<div class="form-group">
		<label for="email" class="col-sm-5 control-label">Email</label>
		<div class="col-sm-3">
			<input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="">
		</div>
	</div>
      <br>
      <div style="text-align:center" class="button">
        <button class="btn btn-primary btn-lg" type="submit" name="submit">Pošlji</button>
      </div>
    </form>
    </div>
		</div>

	</div><!-- Content will go here -->
</body>
</html>
