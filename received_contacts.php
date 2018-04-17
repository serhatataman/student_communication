<?php
	
	$servername = "localhost";
	$username = "username";
	$password = "";
	$dbname = "gtdatabase";
	
	
	$connection = mysqli_connect($servername,$username,$password,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	
	$query = "SELECT * FROM contacts";
	
	if($result = mysqli_query($connection,$query))
	{
		//fetch one and one row
		while($row=mysqli_fetch_row($result)) //0-name_/1-surname_/2-type_/3-subject
		{
			echo "<p><strong>Name:</strong>$row[0]</p>
				  <p><strong>Surname:</strong>$row[1]</p>
				  <p><strong>Type:</strong> $row[2]</p>
				  <p><strong>Subject:</strong> $row[3]</p>
				  ";
		}
		//free result set 
		mysqli_free_result($result);
		
	}
	mysqli_close($connection);
	
?>