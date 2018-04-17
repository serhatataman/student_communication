<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="fonts/contact.css">

</head>
<body>

<?php 

if(!isset($_SESSION))
	session_start();

$nameErr = $idErr = $passwordErr = "";
$name    = $id    = $password    = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	if(empty($_POST["name"]))
		$nameErr = "Channel name is required !";
	else{
		$name = test_input($_POST["name"]);
		//check if the name contains only letters and whitespace
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
			$nameErr = "Invalid channel name ! . Only letters and white space allowed !";
	}
	
	if(empty($_POST["id"]))
		$idErr = "Channel ID is required !";
	else{
		$id = test_input($_POST["id"]);
	}
	
	if(empty($_POST["password"]))
	{
		$passwordErr = "Channel password is required !";
	}
	else
	{
		$password = test_input($_POST["password"]);
	}

	if((!empty($_POST["name"])) && (!empty($_POST["id"]))&& (!empty($_POST["password"])))
	{
	
	$servername = "localhost";
	$username = "username";
	$dbpassword = "";
	$dbname = "gtdatabase";

    $connection = mysqli_connect($servername,$username,$dbpassword,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	else {
		
		$query = "SELECT ID FROM channel WHERE ID='$id'";
		if(mysqli_query($connection,$query))
		{
			echo "Channel already exists !<br>";
		}
		else{
			$user_id=$_SESSION['user_id'];
		
			$insert= "INSERT INTO channel (ID,Name,Password,Owner_ID) 
					VALUES('$id','$name','$password','$user_id')";      
		
			if(mysqli_query($connection,$insert))
			{
				echo "Data inserted to database successfully !<br>";
				mysqli_close($connection);
				header("Location: user.php"); //after saving data return to instructor page
				exit;
			}
			else
				die("Data insertion failed ! ". mysqli_error($connection));
		
		}
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
<form name="Create_channel" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <table>
  <h3>Create Channel</h3>
    <tr> 
      <td>Channel ID</td>
      <td><input name="id" type="text" id="id" placeholder="ex: CEN123"></td>
	  <td><span style="color:red">* <?php echo $idErr; ?></span></td>
    </tr>
    
	<tr> 
      <td>Channel Name</td>
      <td><input name="name" type="text" id="name" placeholder="ex: System Programming"></td>
	  <td><span style="color:red">* <?php echo $nameErr; ?></span></td>
	</tr>
	
    <tr> 
      <td>Channel's Password</td>
      <td><input name="password" type="text" id="password" placeholder="ex: CEN123_2012"></td>
	  <td><span style="color:red">* <?php echo $passwordErr; ?></span></td>
    </tr>
	
    <tr> <td></td>
      <td><input name="add" type="submit" id="add" value="Submit"></td>
    </tr>
	
  </table>
  </form>
  </div>
</body>
</html>
