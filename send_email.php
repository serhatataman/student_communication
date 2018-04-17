<?php

	if(!isset($_SESSION)) 
        session_start();
	
	$servername = "localhost";
	$username = "username";
	$password = "";
	$dbname = "gtdatabase";
	
	$channel_id=$_SESSION['channel_id']; //getting channel id from SESSIONS .
	$user_id=$_SESSION['user_id'];
	
	$studentIDs = [] ; //store studentIDs to here to fetch their names and surnames
	$studentName = [] ;
	$studentSurname = [] ;
	
	$nameErr = $emailErr = $storyErr = $headlineErr = "";
	$name    = $email    = $story    = $headline    = "";
	
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
	
	
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	function checkValid()
	{
		if(empty($_POST["headline"]))
			$headlineErr = "Headline is required !";
		else
			$headline = test_input($_POST["headline"]);
	
		if(empty($_POST["story"]))
			$storyErr = "Story is required !";
		else
			$story = test_input($_POST["story"]);
		
		if((!empty($_POST["headline"]))&& (!empty($_POST["story"])))
		{
			sendMail($headline,$story);// After validation, send the mails !!!
		}
	}
	
	function sendMail($headline,$story)
	{
		$servername = "localhost";
		$username = "username";
		$password = "";
		$dbname = "gtdatabase";
		
		$from_name = $_SESSION['user_name'];
		$from_surname = $_SESSION['user_surname'];
		
		$connection = mysqli_connect($servername,$username,$password,$dbname);
		if(!$connection)
			die("Database connection failed: " . mysqli_connect_error());
			
		if(isset($_POST['separately'])) // if user wanted to send emails separately
		{
			foreach($_POST['check_list'] as $student_id)
			{
				$query = "SELECT Email FROM student WHERE ID='$student_id'";
				$to=mysqli_query($connection,$query);
				
	//			mail($to,$headline,$story) ;  // Host needed for mail function !!!!!!
				
				$insert= "INSERT INTO student_message (Student_ID,From_Name,From_Surname,Headline,Story,Date) 
						  VALUES('$student_id','$from_name','$from_surname','$headline','$story',NOW())";
		
				if(mysqli_query($connection,$insert))
					echo "Data inserted to database successfully !<br>";
				else
					die("Data insertion failed ! ". mysqli_error($connection));
			}
		}
		else{ // else user wants to send email to all students
			foreach($studentIDs as $student_id) // get all students who enrolled the class 
			{
				$query = "SELECT Email FROM student WHERE ID='$student_id'";
				$to=mysqli_query($connection,$query);
				
	//			mail($to,$headline,$story) ;  // Host needed for mail function !!!!!!
				
				$insert= "INSERT INTO student_message (Student_ID,From_Name,From_Surname,Headline,Story,Date) 
						  VALUES('$student_id','$from_name','$from_surname','$headline','$story',NOW())";
		
				if(mysqli_query($connection,$insert))
					echo "Data inserted to database successfully !<br>";
				else
					die("Data insertion failed ! ". mysqli_error($connection));
			}
		}
		
		mysqli_close($connection);
	}
	
	if(isset($_POST['separately']))
	{
		if(!empty($_POST['check_list'])) 
		{
			checkValid();// check if the inputs are valid !!!
		}
		else{
			echo "<b>Please Select at least One Option.</b>";
			}
	}
		
	if(isset($_POST['all']))
	{
		checkValid();// check if the inputs are valid !!!
		
		echo "Message has been sent to all students. !!!";
	}
	
	if(isset($_POST['cancel']))
	{
		header("Location: user.php");
		exit;
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
</head>
<body>
<div class="container">
<h2>Mail System</h2>

	<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	 <table>

    <tr> 
      <td>Subject</td>
      <td><input name="headline" type="text" id="headline"></td>
	  <td><span style="color:red">* <?php echo $headlineErr; ?></span></td>
    </tr>
	
    <tr> 
      <td>Text</td>
      <td colspan="2"><textarea name="story" id="story"></textarea></td>
	  <td><span style="color:red">* <?php echo $storyErr; ?></span></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center">
          <input name="hiddenField" type="hidden" value="add_n">
        </div></td>
    </tr>
  </table>
	<br><br>
	<label>Select students :</label><br>
		
	<?php
		for($i = 0; $i <= (count($studentIDs))-1; $i++)
			echo '<input type="checkbox" name="check_list[]" value="'.$studentIDs[$i].'"><label>'.$studentName[$i].' '.$studentSurname[$i].'</label><br>';
	?>
	<input type="submit" name="separately" value="Submit"/>
	<input type="submit" name="all" value="Send to All"/> 
	<input type="submit" name="cancel" value="Cancel"><br><br>
		
</form>
</div>
</body>
</html>