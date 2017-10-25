<?php
include("config.php");
session_start();
$command = "";

if($_SESSION['verified'] == 0){

						$_SESSION['verified'] = 1;
						$tags = array("Dvojiško drevo", "Sklad", "Unija", "Urejanje", "Verižni seznam", "Vsota", "Drugo");
						
					
								foreach ($tags as $tag) {
												
											$id = str_replace(" ", "", $tag);

											$tempCommand = '<li data-target="#'.$id.'" data-toggle="collapse"><div class="dropdown" >
					<span class="glyphicon glyphicon-chevron-right"></span> <strong>'.$tag.'</strong>
				</div>
				<li style="list-style: none; display: inline">
					<div class="collapse" id="'.$id.'">
						<div class="verticalLine">
							<ul>
							
							<div class="listItem">';
										$verified = $_SESSION['verified'];
										$lowercase = strtolower($tag);	
										$sql = mysqli_query($db, "SELECT * FROM data_csharp WHERE tag = '$tag' AND verified = '$verified'");

										while($row = mysqli_fetch_assoc($sql)){
											$title = $row["question"];
											$data_ID = $row['ID'];
											$tempCommand = $tempCommand.'<li><button class="link" onclick="text('.$data_ID.')" style="text-align: left;" data-id="'.$data_ID.'">'.$title.'</button></li>';
										}
										$tempCommand = $tempCommand.'</div>

							</ul>
						</div>
					</div>
				</li>';

		
							
											$command = $command.''.$tempCommand;
										}

										

					


	
}
else{
	$_SESSION['verified'] = 0;
					$tags = array("Dvojiško drevo", "Sklad", "Unija", "Urejanje", "Verižni seznam", "Vsota", "Drugo");
						
					
								foreach ($tags as $tag) {
												
											$id = str_replace(" ", "", $tag);

											$tempCommand = '<li data-target="#'.$id.'" data-toggle="collapse"><div class="dropdown" >
					<span class="glyphicon glyphicon-chevron-right"></span> <strong>'.$tag.'</strong>
				</div>
				<li style="list-style: none; display: inline">
					<div class="collapse" id="'.$id.'">
						<div class="verticalLine">
							<ul>
							
							<div class="listItem">';
										$verified = $_SESSION['verified'];
										$lowercase = strtolower($tag);	
										$sql = mysqli_query($db, "SELECT * FROM data_csharp WHERE tag = '$tag' AND verified = '$verified'");

										while($row = mysqli_fetch_assoc($sql)){
											$title = $row["question"];
											$data_ID = $row['ID'];
											$tempCommand = $tempCommand.'<li><button class="link" onclick="text('.$data_ID.')" style="text-align: left;" data-id="'.$data_ID.'">'.$title.'</button></li>';
										}
										$tempCommand = $tempCommand.'</div>

							</ul>
						</div>
					</div>
				</li>';

		
							
											$command = $command.''.$tempCommand;
										}
}


echo $command;

exit;


?>