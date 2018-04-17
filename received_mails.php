<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="fonts/table.css">
</head>
<body>
<h2>Received Messages</h2>
<?php  
	
	if(!isset($_SESSION))
		session_start();
	
	$servername = "localhost";
	$username = "username";
	$password = "";
	$dbname = "gtdatabase";
	
	$connection = mysqli_connect($servername,$username,$password,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	
		$user_id = $_SESSION['user_id'];
		
		$query = "SELECT * FROM student_message WHERE Student_ID='$user_id' ORDER BY date DESC";
		
		if($result = mysqli_query($connection,$query))
		{
			while($row=mysqli_fetch_assoc($result))
			{
				echo "<table>
					<tr><th colspan='2'>".$row['Headline']."</th></tr>
					<tr><td colspan='2'>".$row['Story']."</td></tr>
				    <tr>
						<td><strong>From:</strong>".$row['From_Name']." ".$row['From_Surname']."</td>
						<td><strong>Date:</strong>".$row['Date']."</td>
					</tr>
				</table>
				<br>
				<br>
				  ";
			} 
		mysqli_free_result($result);
		
		}
	mysqli_close($connection);

?>
</body>
</html>