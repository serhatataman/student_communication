<?php

	if(!isset($_SESSION)) 
        session_start();
	
	$servername = "localhost";
	$username = "username";
	$dbpassword = "";
	$dbname = "gtdatabase";
	
	$ID = [] ; 
	$Password = [];
	$Name = [] ;
	$Surname = [] ;
	$Email = [];
	$Phone = [];
	$Type = [];
	
	$connection = mysqli_connect($servername,$username,$dbpassword,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	
	$query = "SELECT * FROM signup_applications"; 
	
	if($result = mysqli_query($connection,$query))
		{
			while($row=mysqli_fetch_assoc($result)) // fetch all id's from signup_applications
			{
				$ID[] = $row['ID'];     //store query result into an array
				$Password[] = $row['Password'];
				$Name[] = $row['Name'];
				$Surname[] = $row['Surname'];
				$Email[] = $row['Email'];
				$Phone[] = $row['Phone'];
				$Type[] = $row['personType'];
			}
			mysqli_free_result($result);
		}
	else
		echo "No one has signed up yet !!!";
	
	mysqli_close($connection);
	
	
if($_SERVER["REQUEST_METHOD"] == "POST")
{	
	function insert($ID,$Password,$Name,$Surname,$Email,$Phone,$Type)
	{
		$servername = "localhost";
		$username = "username";
		$dbpassword = "";
		$dbname = "gtdatabase";
		
		$connection = mysqli_connect($servername,$username,$dbpassword,$dbname);
		if(!$connection)
			die("Database connection failed: " . mysqli_connect_error());
			
		if(isset($_POST['separately'])) // if user wants to add people separately !!!
		{			
			foreach($_POST['check_list'] as $id)
			{
				$query = "SELECT * FROM signup_applications WHERE ID='$id'"; //caution to here, there is different from $_POST['all']
				
				if($result=mysqli_query($connection,$query))
				{
					while($row = mysqli_fetch_assoc($result))
					{
						$id2 = $row['ID'];              //store query result into different variables - because when I write $row['ID'],
						$password2 = $row['Password'];  // it gives syntax error !!!
						$name2 = $row['Name'];
						$surname2 = $row['Surname'];
						$email2 = $row['Email'];
						$phone2 = $row['Phone'];
						$type2 = $row['personType'];
						
						$insert= "INSERT INTO $type2 (ID,Password,Name,Surname,Email,Phone) 
								  VALUES('$id2','$password2','$name2','$surname2','$email2','$phone2')";
								  
						if(mysqli_query($connection,$insert)) // whenever query is successfull,  
						{									// then we have to drop the inserted person from signup_applications table.
															// because of this we should write drop function to here...
							echo "Data inserted to ".$type2." table successfully !<br>";
							
							$delete= "DELETE FROM signup_applications WHERE ID='$id2'";
							
							if(mysqli_query($connection,$delete))
								echo "Data deleted from student_applications successfully !<br>";
							else
								die("Data deletion failed ! ". mysqli_error($connection));
							
							header("Refresh:0"); //after insertion and deletion refresh the page.
												 // this provides, the data which we inserted will be disappear from page.
						}
						else
							die("Data insertion failed ! ". mysqli_error($connection));
									  
					}
				}
				else
					die("Data insertion failed ! ". mysqli_error($connection));
				
			}
		}
		else if(isset($_POST['all'])) // if user wants to add all people who applied 
		{
				$query = "SELECT * FROM signup_applications "; //caution to here, there is different from $_POST['separately']
				
				if($result = mysqli_query($connection,$query))
				{
					while($row = mysqli_fetch_assoc($result))
					{
						$id2 = $row['ID'];     //store query result into an array
						$password2 = $row['Password'];
						$name2 = $row['Name'];
						$surname2 = $row['Surname'];
						$email2 = $row['Email'];
						$phone2 = $row['Phone'];
						$type2 = $row['personType'];
						
						// personType is equal to database name. so if it is student , it will add member to student table.
						//else if it is instructor it will add to instructor table
						$insert= "INSERT INTO $type2 (ID,Password,Name,Surname,Email,Phone) 
								  VALUES('$id2','$password2','$name2','$surname2','$email2','$phone2')";
					
						if(mysqli_query($connection,$insert))// whenever query is successfull,  
						{									// then we have to drop the inserted person from signup_applications table.
															// because of this we should write drop function to here...
							echo "Data inserted to ".$type2." table successfully !<br>";
							
							$delete= "DELETE FROM signup_applications WHERE ID='$id2'";
							
							if(mysqli_query($connection,$delete))
								echo "Data deleted from student_applications successfully !<br>";
							else
								die("Data deletion failed ! ". mysqli_error($connection));
							
							header("Refresh:0");//after insertion and deletion refresh the page.
												// this provides, the data which we inserted will be disappear from page.
						}
						else
							die("Data insertion failed ! ". mysqli_error($connection));
					}
				}
				else
					echo "There is no applications to insert !!!";
		}
		
		mysqli_close($connection);
	}
	
	if(isset($_POST['separately']))
	{
		if(!empty($_POST['check_list'])) 
			insert($ID,$Password,$Name,$Surname,$Email,$Phone,$Type);
		else
			echo "<b>There is no user applied</b>";
	}
		
	if(isset($_POST['all']))
	{
		insert($ID,$Password,$Name,$Surname,$Email,$Phone,$Type);
		echo "All users have been approved !!!";
	}
}
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="fonts/table.css">
</head>
<body>

<h2>Signup Requests</h2>

	<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	 
	<label>Approve applications :</label><br>
	<tr ></tr>
	<table>
		<tr>
			<th>Select</th>
			<th>Person Type</th>
			<th>ID</th>
			<th>Name</th>
			<th>Surname</th>
			<th>Email</th>
			<th>Phone</th>
		</tr>
		<?php
		for($i = 0; $i <= (count($ID))-1; $i++)
			echo '	<tr>
						<td><input type="checkbox" name="check_list[]" value="'.$ID[$i].'"></td>
						<td>'.$Type[$i].'</td>
						<td>'.$ID[$i].'</td>
						<td>'.$Name[$i].'</td>
						<td>'.$Surname[$i].'</td>
						<td>'.$Email[$i].'</td>
						<td>'.$Phone[$i].'</td>
					</tr>
					<br>';
		?>
	</table>
	
	<input type="submit" name="separately" value="Approve"/> 
	<input type="submit" name="all" value="Approve All">
	<input type="submit" name="delete" value="Delete"/><br><br>
		
</form>

</body>
</html>