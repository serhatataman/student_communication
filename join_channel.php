<?php
if(!isset($_SESSION))
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="fonts/contact.css">
</head>
<body>

<?php 

$idErr = $passwordErr = "";
$ID    = $password    = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST["id"]))
		$idErr = "Channel ID is required !";
	else{
		$ID = test_input($_POST["id"]);
	}
	
	if(empty($_POST["password"]))
	{
		$passwordErr = "Channel password is required !";
	}
	else
	{
		$password = test_input($_POST["password"]);
	}

	if((!empty($_POST["id"])) && (!empty($_POST["password"])))
	{
	
	$servername = "localhost";
	$username = "username";
	$dbpassword = "";
	$dbname = "gtdatabase";

    $connection = mysqli_connect($servername,$username,$dbpassword,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	else {
			/*$student_id=$_SESSION['user_id'];
		
		$query = "SELECT * FROM student_channel WHERE Student_ID='$student_id' AND Channel_ID='$ID'";
		
		if(mysqli_query($connection,$query))
		{
			echo "You already enrolled the class !<br>";
		}
		else{*/
			$queryChannel = "SELECT ID,Password FROM channel WHERE ID='$ID' AND Password='$password';";
			$resultChannel = mysqli_query($connection,$queryChannel);     
		
			$rowChannel = mysqli_fetch_assoc($resultChannel); // the data which coming from $result has been converted to rows to $row variable
		
			if($rowChannel["ID"]==$ID && $rowChannel["Password"]==$password)
			{ 
				$student = $_SESSION['user_id'];
				$channel = $rowChannel["ID"];
			
				$addStudentToChannel="INSERT INTO student_channel (Student_ID,Channel_ID)
									VALUES('$student','$channel')";
								  
				mysqli_query($connection,$addStudentToChannel);
			
				mysqli_close($connection);
		
				header("Location: user.php");
				exit;
			}
			else 
				echo "Channel is not exist !";
		//}
		
		mysqli_close($connection);
	}
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
<form name="Join_channel" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <table>
	<h3>Join Channel</h3>
    <tr> 
      <td>Channel ID</td>
      <td><input name="id" type="text" id="id" placeholder="ex: CEN123"></td>
	  <td><span style="color:red">* <?php echo $idErr; ?></span></td>
    </tr>
	
    <tr> 
      <td>Channel's Password</td>
      <td><input name="password" type="text" id="password" placeholder="ex: CEN123_2012"></td>
	  <td><span style="color:red">* <?php echo $passwordErr; ?></span></td>
    </tr>
	
    <tr> <td></td>
      <td><input name="add" type="submit" id="add" value="Submit">   <input type="submit" name="cancel" value="Cancel"></td>
	  <td></td>
    </tr>
	
  </table>
  </form>
  </div>
</body>
</html>
