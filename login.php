<?php
if(!isset($_SESSION))
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="fonts/contact.css">
<style>
.error{
	color: #FF0000;
}
</style>
</head>
<body>

<?php

//define all varibles and set to empty values
$IDErr = $passwordErr = "";
$ID    = $password    = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["ID"]))
		$IDErr = "ID is required !";
	else 
		$ID = test_input($_POST["ID"]);
	//----------------------------------------
	if(empty($_POST["password"]))
		$passwordErr = "Password is required !";
	else
		$password = test_input($_POST["password"]);
	
	if( (!empty($_POST["ID"])) && (!empty($_POST["password"])))
	{
		//connect to database and insert values
		$servername = "localhost";
		$username = "username";
		$dbpassword = "";
		$dbname = "gtdatabase";

		$connection = mysqli_connect($servername,$username,$dbpassword,$dbname);
		if(!$connection)
			die("Database connection failed: " . mysqli_connect_error());
	
		$queryAdmin = "SELECT * FROM admin WHERE ID='$ID' AND Password='$password';";
		$resultAdmin= mysqli_query($connection,$queryAdmin);
		
		$queryStudent = "SELECT * FROM student WHERE ID='$ID' AND Password='$password';";
		$resultStudent = mysqli_query($connection,$queryStudent);
		
		$queryInstructor = "SELECT * FROM instructor WHERE ID='$ID' AND Password='$password';";
		$resultInstructor= mysqli_query($connection,$queryInstructor);
		
		$rowAdmin = mysqli_fetch_assoc($resultAdmin);
		$rowStudent = mysqli_fetch_assoc($resultStudent); // the data which coming from $result has been converted to rows to $row variable
		$rowInstructor = mysqli_fetch_assoc($resultInstructor);
		
		if($rowStudent["ID"]==$ID && $rowStudent["Password"]==$password)
		{
			$_SESSION['user_type']="student"; //identify to who the user is
			$_SESSION['user_id']=$rowStudent["ID"];  
			$_SESSION['user_name']=$rowStudent["Name"];
			$_SESSION['user_surname']=$rowStudent["Surname"];
			$_SESSION['user_email']=$rowStudent["Email"];
			mysqli_close($connection);
			header("Location: user.php");
		}
		else if($rowInstructor["ID"]==$ID && $rowInstructor["Password"]==$password)
		{ 
			$_SESSION['user_type']="instructor"; //identify to who the user is 
			$_SESSION['user_id']=$rowInstructor["ID"]; 
			$_SESSION['user_name']=$rowInstructor["Name"];
			$_SESSION['user_surname']=$rowInstructor["Surname"];
			$_SESSION['user_email']=$rowInstructor["Email"];
			mysqli_close($connection);
			header("Location: user.php");
		}
		else if($rowAdmin["ID"]==$ID && $rowAdmin["Password"]==$password)
		{ 
			$_SESSION['user_type']="admin"; //identify to who the user is 
			$_SESSION['user_id']=$rowAdmin["ID"]; 
			$_SESSION['user_name']=$rowAdmin["Name"];
			$_SESSION['user_surname']=$rowAdmin["Surname"];
			$_SESSION['user_email']=$rowAdmin["Email"];
			mysqli_close($connection);
			header("Location: user.php");
		}
		else 
		{
			mysqli_close($connection);
			echo "Invalid ID or Password !";
		}
		/*if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				if($row["Student_ID"]==$ID || $row["Password"]==$password)
					echo "Query succeed ! : ". $row["Student_ID"]." ".$row["Password"];
			}
		} 
		else {
			echo "0 results";
		}*/
	}
}

function test_input($data)
{
	$data = trim($data); //Strip unnecessary characters (extra space, tab, newline) from the user input data (with the PHP trim() function)
	$data = stripslashes($data); //Remove backslashes (\) from the user input data (with the PHP stripslashes() function)
	$data = htmlspecialchars($data); //converts special characters to HTML entities
	return $data;
}

?>
<div class="container">
<fieldset>
<legend>Login Panel</legend>

<form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="login">
<table>

	<tr>
		<td><label>ID:</label></td>
		<td><input type="text" name="ID"><span class="error"> <?php echo $IDErr; ?></span></td>
	</tr>
	
	<tr>
		<td><label>Password:</label></td>
		<td><input type="password" name="password" style="width: 100%; padding: 12px;  border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-top: 6px; margin-bottom: 16px; resize: vertical;"></td>
		<td><span class="error"> <?php echo $passwordErr; ?></span></td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="checkbox" name="rememberme"><label>Remember me</label></td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Submit"></td>
	</tr>
	
</table>
</form>

</fieldset>
</div>
</body>
</html>











