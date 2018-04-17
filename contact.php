<?php

$nameErr = $surnameErr = $typeErr = $subjectErr = "";
$name    = $surname    = $type    = $subject    = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
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
	//------------------------------------------------
	if(empty($_POST["type"]))
	{
		$typeErr = "Person type is required !";
	}
	else
	{
		$type = $_POST["type"];
	}
	//------------------------------------------------
	if(empty($_POST["subject"]))
	{
		$subjectErr = "Subject is required !";
	}
	else
	{
		$subject = test_input($_POST["subject"]);
	}

	if( (!empty($_POST["name"]))&& (!empty($_POST["surname"]))&& 
	    (!empty($_POST["type"])) && (!empty($_POST["subject"])) &&
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
			else{
			
				$insert = "INSERT INTO contacts (Name,Surname,Type,Subject)
						VALUES('$name','$surname','$type','$subject')";
			
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
</head>
<body>

<div class="container">
  <form action="/gt/contact.php" method="post">
	<h1>Contact Form</h1>
    <label for="name">First Name</label><span class="error">* <?php echo $nameErr; ?></span>
    <input type="text" id="name" name="name" placeholder="Your name..">

    <label for="surname">Last Name</label><span class="error">* <?php echo $surnameErr; ?></span>
    <input type="text" id="surname" name="surname" placeholder="Your last name..">

    <label for="type">Type</label><span class="error">* <?php echo $typeErr; ?></span>
    <select id="type" name="type">
      <option value="instructor">Instructor</option>
      <option value="student">Student</option>
	  <option value="other">Other</option>
    </select>

    <label for="subject">Subject</label><span class="error">* <?php echo $subjectErr; ?></span>
    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

    <input type="submit" name="submit" value="Submit">

  </form>
</div>

</body>
</html>