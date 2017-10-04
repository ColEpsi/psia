<?php
  include("config.php");
  session_start();
  $_SESSION['verified'] = 1;
/*
  if($_SERVER["REQUEST_METHOD"] == "POST") {
      $weight = mysqli_real_escape_string($db,$_POST['weight']);
      $height = mysqli_real_escape_string($db,$_POST['height']);
      $username = $_SESSION['username'];
      $date = date("Y/m/d");
      $resultID = mysqli_fetch_assoc(mysqli_query($db, "SELECT ID FROM users WHERE username='$username'"));
      $ID = $resultID['ID'];
      $insert = mysqli_query($db, "INSERT INTO health_data (date, height, weight, user_ID) VALUES ('$date', '$height', 
        '$weight', '$ID')");
   }
*/    
  $message = "";
  $username = $_SESSION['username'];
  $user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE (email='$username' or username = '$username')"));
  $name = $user['name'];
  $surname = $user['surname'];
  $permission_level = $user['permission_level'];
  $credentials = "$name $surname";
  
  $verified_html = "";
  $verified_query = mysqli_query($db, "SELECT * FROM data WHERE verified=0");

  while($row = mysqli_fetch_assoc($verified_query)){
      $contributor_ID = $row['contributor_ID'];
      $contributor = mysqli_fetch_assoc(mysqli_query($db, "SELECT name, surname FROM users WHERE ID='$contributor_ID'"));
      $verified_html .= " 
                <tr class='clickable-row' data-id='".$row['ID']."'>
                <td>".$contributor['name']." ".$contributor['surname']."</td>
                <td>".$row['question']."</td>
                </tr>";
  }

?>
<html>
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
  <link rel="shortcut icon" type="image/png" href="FMF_favicon.png"/>
	<link href="https://www.w3schools.com/w3css/3/w3.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js">
	</script>
	<script>
      $(document).ready(function() {
    $('#table').DataTable( {
        columnDefs: [ {
            orderable: false,
            targets:   0
        } ],
        order: [[ 1, 'asc' ]]
    } );
} );
	</script>
	<script >
    $(document).ready(function(){ 
        $('.clickable-row').click(function(){
    		var data_id = $(this).data('id');
            window.location = "session_create.php?session_name="+data_id;
   		});
    });
	</script>
  <style>
    
  
  </style>
	<link href="main.css" rel="stylesheet" type="text/css">
	<title>Programski jezik C#</title>
</head>
<body>
	<div class="container">
		<nav class="navbar sticky-topa navbar-inverse">
            <a class="navbar-brand" href="logged_in.php">Nazaj</a>
			<div class="container-fluid">
				<ul class="nav fixed-top navbar-nav navbar-right">
					
					<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><span class="glyphicon glyphicon-user"></span> <?php echo $credentials; ?></b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
											 <button onclick="window.location.href='index.php'" type="submit" name="submit" class="btn btn-danger btn-block">Odjava</button>
											 <br>
										
										
								 
							</div>
					 </div>
				</li>
			</ul>
        </li>
				</ul>
			</div>
		</nav>
		<div class="container-fluid" style="background-color: white; height: 1000px">
          <h2>Nepreverjene objave</h2>
          <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Objavil</th>
                <th>Naslov vprašanja</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Objavil</th>
                <th>Naslov vprašanja</th>
            </tr>
        </tfoot>
        <tbody>
          <?php
            echo $verified_html;
          ?>
        </tbody>
    </table>
		</div>
		
	</div><!-- Content will go here -->
</body>
</html>