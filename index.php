<?php

$servername = "srv768.hstgr.io";
$dBUsername = "u579024306_domo";
$dBPassword = "And20vas.08";
$dBName = "u579024306_domotica";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}


if (isset($_POST['toggle_LED'])) {
	$sql = "SELECT * FROM LED_status;";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);
	
	if($row['status'] == 0){
		$update = mysqli_query($conn, "UPDATE LED_status SET status = 1 WHERE id = 1;");		
	}		
	else{
		$update = mysqli_query($conn, "UPDATE LED_status SET status = 0 WHERE id = 1;");		
	}
	if($row['status'] == 0){
		$update = mysqli_query($conn, "UPDATE LED_status SET status = 1 WHERE id = 2;");		
	}		
	else{
		$update = mysqli_query($conn, "UPDATE LED_status SET status = 0 WHERE id = 2;");
	}
	if($row['status'] == 0){
		$update = mysqli_query($conn, "UPDATE LED_status SET status = 1 WHERE id = 3;");		
	}		
	else{
		$update = mysqli_query($conn, "UPDATE LED_status SET status = 0 WHERE id = 3;");
	}
}



$sql = "SELECT * FROM LED_status;";
$result   = mysqli_query($conn, $sql);
$row  = mysqli_fetch_assoc($result);	

?>

<style>
	.wrapper{
		width: 50%;
		padding-top: 50px;
	}
	.col_1{
		width: 33.3333333%;
		float: right;
		min-height: 1px;
	}
	.col_2{
		width: 33.3333333%;
		float: center;
		min-height: 1px;
	}
	.col_3{
		width: 33.3333333%;
		float: left;
		min-height: 1px;
	}
	#submit_button{
		background-color: #2bbaff; 
		color: #FFF; 
		font-weight: bold; 
		font-size: 20; 
		border-radius: 15px;
    	text-align: center;
	}
	#submit_button2{
		background-color: #2bbaff; 
		color: #FFF; 
		font-weight: bold; 
		font-size: 20; 
		border-radius: 15px;
    	text-align: center;
	}
	#submit_button3{
		background-color: #2bbaff; 
		color: #FFF; 
		font-weight: bold; 
		font-size: 20; 
		border-radius: 15px;
    	text-align: center;
	}
	.led_img{
		height: 400px;		
		width: 50%;
		object-fit: contain;
		object-position: center;
	}
	
	@media only screen and (max-width: 600px) {
		.col_1 {
			width: 50%;
		}
		.col_2 {
			width: 50%;
		}
		.col_3 {
			width: 50%;
		}
		.wrapper{
			width: 100%;
			padding-top: 5px;
		}
		.led_img{
			height: 300px;		
			width: 50%;
			margin-right: 10%;
			margin-left: 10%;
			object-fit: cover;
			object-position: center;
		}
	}

</style>

<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <body>
	       <div class="wrapper" id="refresh">
		    <div class="col_1">
		   </div>

		   <div class="col_1" >
			
			<?php echo '<h2 style="text-align: center;">The LED is: '.$row['status'].'</h2>';?>
			
			<div class="col_1">
			</div>
			
			<div class="col_1" style="text-align: center;">
			<form action="index.php" method="post" id="LED" enctype="multipart/form-data">			
				<input id="submit_button" type="submit" name="toggle_LED" value="Luz 1" />
			</form>
				
			<script type="text/javascript">
			$(document).ready (function () {
				var updater = setTimeout (function () {
					$('div#refresh').load ('index.php', 'update=true');
				}, 1000);
			});
			</script>
			<br>
			<br>
			<?php
				if($row['status'] == 0){?>
				<div class="led_img">
					<img id="contest_img" src="led_off.png" width="50%" height="50%">
				</div>
			<?php	
				}
				else{ ?>
				<div class="led_img">
					<img id="contest_img" src="led_on.png" width="50%" height="50%">
				</div>
			<?php
				}
			?>
			
				
			</div>
				
			<div class="col_1">
			</div>
		</div>

        <!-- +++++++++++++++++++++++++++++++++++++++ AGREGO EL LED 2 +++++++++++++++++++++++++++++++++++ -->
        <div class="col_2" >
			
			<?php echo '<h2 style="text-align: center;">The LED2 is: '.$row['status'].'</h2>';?>
			
			<div class="col_2">
			</div>
			
			<div class="col_2" style="text-align: center;">
			<form action="index.php" method="post" id="LED2" enctype="multipart/form-data">			
				<input id="submit_button2" type="submit" name="toggle_LED" value="Luz 2" />
			</form>
				
			<script type="text/javascript">
			$(document).ready (function () {
				var updater = setTimeout (function () {
					$('div#refresh').load ('index.php', 'update=true');
				}, 1000);
			});
			</script>
			<br>
			<br>
			<?php
				if($row['status'] == 0){?>
				<div class="led_img">
					<img id="contest_img" src="led_off.png" width="50%" height="50%">
				</div>
			<?php	
				}
				else{ ?>
				<div class="led_img">
					<img id="contest_img" src="led_on.png" width="50%" height="50%">
				</div>
			<?php
				}
			?>
        </div>
		<!-- +++++++++++++++++++++++++++++++++++++++ AGREGO EL LED 3 +++++++++++++++++++++++++++++++++++ -->
        <div class="col_2" >
			
			<?php echo '<h2 style="text-align: center;">The LED3 is: '.$row['status'].'</h2>';?>
			
			<div class="col_2">
			</div>
			
			<div class="col_2" style="text-align: center;">
			<form action="index.php" method="post" id="LED3" enctype="multipart/form-data">			
				<input id="submit_button2" type="submit" name="toggle_LED" value="Luz 3" />
			</form>
				
			<script type="text/javascript">
			$(document).ready (function () {
				var updater = setTimeout (function () {
					$('div#refresh').load ('index.php', 'update=true');
				}, 1000);
			});
			</script>
			<br>
			<br>
			<?php
				if($row['status'] == 0){?>
				<div class="led_img">
					<img id="contest_img" src="led_off.png" width="50%" height="50%">
				</div>
			<?php	
				}
				else{ ?>
				<div class="led_img">
					<img id="contest_img" src="led_on.png" width="50%" height="50%">
				</div>
			<?php
				}
			?>
        </div>
    


           
        
    </body>
</html>
