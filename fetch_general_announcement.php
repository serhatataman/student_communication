<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="fonts/table.css">
</head>
<body>
<h2>General Announcements</h2>
<?php
	
	$servername = "localhost";
	$username = "username";
	$password = "";
	$dbname = "gtdatabase";
	
	
	$connection = mysqli_connect($servername,$username,$password,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	
	$query = "SELECT * FROM news ORDER BY date DESC"; //it will show the latest news... via DESC
	
	if($result = mysqli_query($connection,$query))
	{
		//fetch one and one row
		while($row=mysqli_fetch_row($result)) //0-headline_/1-story_/2-name_/3-email_/4-date
		{
			echo "<div style='background:white'><br>
					<table style='width:100%'>
					<tr><th colspan='3'>$row[0]</th></tr>
					<tr><td colspan='3'>$row[1]</td></tr>
				    <tr>
						<td ><strong>Instructor:</strong> $row[2]</td>
						<td ><strong>E-mail:</strong> $row[3]</td>
						<td ><strong>Release date:</strong> $row[4]</td>
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