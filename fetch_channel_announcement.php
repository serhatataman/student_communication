<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="fonts/table.css">
</head>
<body>
<?php

    if(!isset($_SESSION)) 
        session_start(); 

	$servername = "localhost";
	$username = "username";
	$password = "";
	$dbname = "gtdatabase";
	
	$channel_id=$_SESSION['channel_id']; //getting channel id from SESSIONS .
	
	$connection = mysqli_connect($servername,$username,$password,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	
	$query = "SELECT * FROM channel_news WHERE Channel_ID='$channel_id' ORDER BY date DESC"; //it will show the latest news... via DESC --depends on channel id
	
	if($result = mysqli_query($connection,$query))
	{
		//fetch one and one row
		while($row=mysqli_fetch_row($result)) //0-Channel_ID_/1-headline_/2-story_/3-name_/4-email_/5-date
		{
			echo "<div style='background:white'><br>
				<table style='width:100%'>
					<tr><th colspan='3'>$row[1]</th></tr>
					<tr><td colspan='3'>$row[2]</td></tr>
				    <tr>
						<td><strong>Instructor:</strong> $row[3]</td>
						<td><strong>E-mail:</strong> $row[4]</td>
						<td><strong>Release date:</strong> $row[5]</td>
					</tr>
				</table>
				<br>
				<br>
				</div>
				  ";
		}
		//free result set 
		mysqli_free_result($result);
		
	}
	mysqli_close($connection);

?>
</body>
</html>