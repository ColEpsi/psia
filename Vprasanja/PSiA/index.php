<?php
   include("config.php");
   session_start();
   $_SESSION['verified'] = 1;
   //$_SESSION['name'] = 0;
   //$_SESSION['surname'] = 0;
   $error = "";
   if(isset($_POST['submit'])) {
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
          $_SESSION['logged_on'] = true;
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
	<script>
		function checkbox(){
    		var xhttp = new XMLHttpRequest();
    		  xhttp.onreadystatechange = function() {
        	if (xhttp.readyState == 4 && xhttp.status == 200) {
            document.getElementById("contents").innerHTML=this.responseText;

        	}
     		};
      	xhttp.open("GET", "checkbox.php", true);
      	xhttp.send();
    	}

    	function text(data_id){
    		if (window.XMLHttpRequest) {
    		// IE7+, Firefox, Chrome, Opera, Safari
    		xmlhttp=new XMLHttpRequest();
  			} else { //  IE6, IE5
  			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  			}
  			xmlhttp.onreadystatechange=function() {
   			 if (this.readyState==4 && this.status==200) {
     		 document.getElementById("display").innerHTML=this.responseText;
   			 }
  			}
  			xmlhttp.open("GET","ajax.php?q="+data_id,true);
  			xmlhttp.send();

    	}


		$(document).ready(function(){
    	$('.link').click(function(){
    		var data_id = $(this).data('id');
    		if (window.XMLHttpRequest) {
    		// IE7+, Firefox, Chrome, Opera, Safari
    		xmlhttp=new XMLHttpRequest();
  			} else { //  IE6, IE5
  			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  			}
  			xmlhttp.onreadystatechange=function() {
   			 if (this.readyState==4 && this.status==200) {
     		 document.getElementById("display").innerHTML=this.responseText;
   			 }
  			}
  			xmlhttp.open("GET","ajax.php?q="+data_id,true);
  			xmlhttp.send();

   		}	);
});
function dropdown(){
  $('#dropdown').addClass('open');
}
	</script>
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Podatkovne strukture in algoritmi</title>
</head>
<body>
	<div class="container">
		<nav class="navbar sticky-topa navbar-inverse">
			<div class="container-fluid">
        <a class="navbar-brand" href="../CSharp/index.php">Programski jezik C#</a>
				<ul class="nav fixed-top navbar-nav navbar-right">
					<li>
						<a href="register.php"><span class="glyphicon glyphicon-user"></span> Registracija</a>
					</li>
					<li class="dropdown" id="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><span class="glyphicon glyphicon-log-in"></span> Prijava</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
								 <form class="form" method="POST" action="" accept-charset="UTF-8" id="login-nav">
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
											 <button type="submit" name="submit" class="btn btn-primary btn-block" id="prijava">Prijava</button>
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
		<div class="container-fluid" style="background-color: white; height: 100%; overflow:auto;">
			<h1>Vprašanja in odgovori iz Podatkovnih struktur in algoritmov</h1>
		<h4>Fakulteta za matematiko in fiziko, Univerza v Ljubljani</h4>
		<hr>
		<div class="col-md-4">
			<!--
			<div class="checkbox">
  				<label><input type="checkbox" name="verification" value="unverified" onchange="checkbox()">Pokaži nepreverjene objave</label>
			</div>
			-->
			<h2>Kazalo</h2>
			<ul>
				<div class="contents" id="contents">
					<?php
						$command = "";
						$sql = mysqli_query($db, "SELECT DISTINCT tag FROM data WHERE verified = 1");

						$tags = array();

						while($row = mysqli_fetch_assoc($sql)){
              $field = $row['tag'];
              $field = str_replace("  ", " ", $field);
							$field = str_replace(", ", ",", $field);
              $field = str_replace(" ,", ",", $field);


							$tag = explode(",", $field);

							$tags = array_merge($tags, $tag);
						}
            print_r(array_values($tags));
						array_push($tags, "Nepreverjene objave");
            $tags = array_map('strtolower', $tags);
            print_r("---------------------");
            print_r(array_values($tags));
            $tags = array_unique($tags);
            print_r("---------------------");
            print_r(array_values($tags));


								foreach ($tags as $tag) {

											$id = str_replace(" ", "", $tag);
                      $tag = ucfirst($tag);
											$tempCommand = '<li data-target="#'.$id.'" data-toggle="collapse"><div class="dropdown" >
					<span class="glyphicon glyphicon-chevron-right"></span> <strong>'.$tag.'</strong>
				</div>
				<li style="list-style: none; display: inline">
					<div class="collapse" id="'.$id.'">
						<div class="verticalLine">
							<ul>

							<div class="listItem">';
                    $tag_comma_comma = '%, '.$tag.',%';
                    $tag_space_comma = '% ,'.$tag.',%';
                    $tag_comma_space =  '%, '.$tag.' %';
                    $tag_space_space =  '% ,'.$tag.' %';
										if(!strcmp($tag, "Nepreverjene objave")){
											$sql = mysqli_query($db, "SELECT * FROM data WHERE verified = 0");
										}
										else{
                      $sql = mysqli_query($db, "SELECT * FROM data WHERE (tag LIKE '{$tag}' OR tag LIKE '%, {$tag}' OR tag LIKE '% ,{$tag}'
                        OR tag LIKE '{$tag}, %' OR tag LIKE '{$tag} ,%'
                        OR tag LIKE '{$tag_comma_comma}' OR tag LIKE '{$tag_space_comma}' OR tag LIKE '{$tag_comma_space}'
                        OR tag LIKE '{$tag_space_space}')  AND verified = 1");
										}

										while($row = mysqli_fetch_assoc($sql)){
											$title = $row["question"];
											$data_ID = $row['ID'];
											$tempCommand = $tempCommand.'<li><button class="link" style="text-align: left;" data-id="'.$data_ID.'">'.$title.'</button></li><hr>';
										}
										$tempCommand = $tempCommand.'</div>

							</ul>
						</div>
					</div>
				</li>';



											$command = $command.''.$tempCommand;
										}

										echo $command;

					?>

			</ul>
		</div>
		<div class="col-md-8">
			<div id="display"></div>
		</div>
		</div>

	</div><!-- Content will go here -->
</body>
</html>
