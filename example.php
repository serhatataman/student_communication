<?php

	if(!isset($_SESSION)) 
        session_start();
	
	$servername = "localhost";
	$username = "username";
	$password = "";
	$dbname = "gtdatabase";
	
	$channel_id=$_SESSION['channel_id']; //getting channel id from SESSIONS .
	
	$studentIDs = [] ; //store studentIDs to here to fetch their names and surnames
	$studentName = [] ;
	$studentSurname = [] ;
	
	$connection = mysqli_connect($servername,$username,$password,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	
	$query = "SELECT Student_ID FROM student_channel WHERE Channel_ID='$channel_id'"; 
	
	if($result = mysqli_query($connection,$query))
		{
			while($row=mysqli_fetch_assoc($result)) // fetch all id's from student_channel
			{
				$studentIDs[] = $row['Student_ID']; //store query result into an array
			}
			mysqli_free_result($result);
		}
	
	
	for($i = 0; $i <= (count($studentIDs))-1; $i++)
	{
		$query = "SELECT Name,Surname FROM student WHERE ID='$studentIDs[$i]'";
		
		if($result = mysqli_query($connection,$query))
		{
			while($row=mysqli_fetch_assoc($result)) // fetch all id's from student_channel
			{
				$studentName[] = $row['Name']; //store query result into an array
				$studentSurname[] = $row['Surname'];
			}
			mysqli_free_result($result);
		}
	
	}
	
	mysqli_close($connection);
	
	
	 function checked() {
        if(isset($_POST['checkAll'])) {
            return 'checked';
        }
        else{
            return '';
        }
    }
	
?>
<!DOCTYPE html>
<html>
<body>

<h2>Mail System</h2>

	<form action="example.php" method="post">
	
		<label>Select students :</label><br>
		
		<?php
			for($i = 0; $i <= (count($studentIDs))-1; $i++)
				echo '<input type="checkbox" name="check_list[]" value="'.$studentIDs[$i].'" '.checked().'><label>'.$studentName[$i].' '.$studentSurname[$i].'</label><br>';
		?>
		<input type="submit" name="submit" value="Submit"/> 
		<input type="submit" name="all" value="Send to All"><br><br>
		<!----- Including PHP Script ----->
		<?php include 'value.php';?>
		
	</form>

</body>
</html>