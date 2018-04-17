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
$IDErr = $nameErr = $surnameErr = $passwordErr = $emailErr = $phoneErr = $genderErr = $personTypeErr = "";
$ID    = $name    = $surname    = $password    = $email    = $phone    = $gender    = $personType    = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["ID"]))
	{
		$IDErr = "Student ID is required !";
	}
	else 
	{
		$ID = test_input($_POST["ID"]);
	}
	//----------------------------------------------
	if(empty($_POST["name"]))
	{
		$nameErr = "Name is required !";
	}
	else
	{
		$name = test_input($_POST["name"]);
		//check if the name contains only letters and whitespace
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
			$nameErr = "Only letters and white space allowed !";
	}
	//----------------------------------------------
	if(empty($_POST["surname"]))
	{
		$surnameErr = "Surname is required !";
	}
	else
	{
		$surname = test_input($_POST["surname"]);
		//check if the surname contains only letters and whitespace
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
			$nameErr = "Only letters and white space allowed !";
	}
	//-----------------------------------------------
	if(empty($_POST["password"]))
	{
		$passwordErr = "Password is required !";
	}
	else
	{
		$password = test_input($_POST["password"]);
	}
	//-----------------------------------------------
	if(empty($_POST["email"]))
	{
		$emailErr = "E-Mail is required !";
	}
	else
	{
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$emailErr = "Invalid e-mail format !";
	}
	//--------------------------------------------------
		$phone = test_input($_POST["phone"]);
	//------------------------------------------------
	if(empty($_POST["gender"]))
	{
		$genderErr = "Gender is required !";
	}
	else
	{
		$gender = test_input($_POST["gender"]);
	}
	//-------------------------------------------------------
	if(empty($_POST["personType"]))
	{
		$personTypeErr = "Person type is required !";
	}
	else
	{
		$personType = test_input($_POST["personType"]);
	}

	if( (!empty($_POST["ID"])) && (!empty($_POST["password"]))&& (!empty($_POST["name"]))&& 
		(!empty($_POST["surname"]))&& (!empty($_POST["email"]))&& (!empty($_POST["phone"])) && 
		(!empty($_POST["personType"])) && (!empty($_POST["gender"])) && (filter_var($email, FILTER_VALIDATE_EMAIL)) &&
		(preg_match("/^[a-zA-Z ]*$/",$name)))
		{
			
			//connect to database and insert values
			$servername = "localhost";
			$username = "username";
			$dbpassword = "";
			$dbname = "gtdatabase";

			$connection = mysqli_connect($servername,$username,$dbpassword,$dbname);
			if(!$connection)
				die("Database connection failed: " . mysqli_connect_error());
			
			//CHECK IF THE USER ALREADY SIGNED IN OR EXIST !!!
			$query = "SELECT ID FROM signup_applications WHERE ID='$ID'";
			$query2 = "SELECT ID FROM student WHERE ID='$ID'";
			$query3 = "SELECT ID FROM instructor WHERE ID='$ID'";
			$query4 = "SELECT ID FROM admin WHERE ID='$ID'";
			
			if(mysqli_query($connection,$query))
				exit("Invalid ID: User is already signed up11 !");
			else if(mysqli_query($connection,$query2))
				exit("Invalid ID: User is already signed up2 !");
			else if(mysqli_query($connection,$query3))
				exit("Invalid ID: User is already signed up3 !");
			else if(mysqli_query($connection,$query4))
				exit("Invalid ID: User is already signed up4 !");
			else{
			
				$insert = "INSERT INTO signup_applications (ID,Password,Name,Surname,Email,Phone,personType)
						VALUES('$ID', '$password', '$name', '$surname', '$email', '$phone','$personType')";
			
				//Check if it is insert
				if(mysqli_query($connection,$insert))
					echo "Data inserted to database successfully !<br>";
				else
					die("Data insertion failed: " . mysqli_error($connection));
			}
			mysqli_close($connection);
			
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
<legend>Registration Form</legend>
<form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="regForm">
<table>

	<tr>
		<td><label>ID:</label></td>
		<td><input type="text" name="ID"></td>
		<td><span class="error">* <?php echo $IDErr; ?></span></td>
	</tr>
	
	<tr>
		<td><label>Name:</label></td>
		<td><input type="text" name="name"></td>
		<td><span class="error">* <?php echo $nameErr; ?></span></td>
	</tr>
	
	<tr>
		<td><label>Surname:</label></td>
		<td><input type="text" name="surname"></td>
		<td><span class="error">* <?php echo $surnameErr; ?></span></td>
	</tr>
	
	<tr>
		<td><label>E-mail:</label></td>
		<td><input type="text" name="email"></td>
		<td><span class="error">* <?php echo $emailErr; ?></span></td>
	</tr>
	
	<tr>
		<td><label>Phone Number:</label></td>
		<td><input type="text" name="phone"></td>
	</tr>
	
	<tr>
		<td><label>Password:</label></td>
		<td><input type="password" name="password" style="width: 100%; padding: 12px;  border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; margin-top: 6px; margin-bottom: 16px; resize: vertical;"></td>
		<td><span class="error">* <?php echo $passwordErr; ?></span></td>
	</tr>
	
	<tr>
		<td><label>Gender:</label></td>
		<td><input type="radio" name="gender" value="male">Male  <span class="error">* <?php echo $genderErr; ?></span></td>
		<td></td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="radio" name="gender" value="female">Female</td>
	</tr>
	<br>
	<tr>
		<td><label>Type: </label></td>
		<td><input type="radio" name="personType" value="student">Student  <span class="error">* <?php echo $personTypeErr; ?></span></td>
		<td></td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="radio" name="personType" value="instructor">Instructor</td>
	</tr>
	
	<tr>
		<td></td>
		<td><input type="submit" name="submit" value="Submit"></td>
	</tr>
	
</table>
</form>
</fieldset>
</div>
<br>
<?php
		
	

?>
</body>
</html>










