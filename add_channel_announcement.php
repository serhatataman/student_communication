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

$nameErr = $emailErr = $storyErr = $headlineErr = "";
$name    = $email    = $story    = $headline    = "";

$channel=$_SESSION['channel_id'];

if($_SERVER["REQUEST_METHOD"] == "POST")
{	

	$name=$_SESSION['user_name'];
	$email=$_SESSION['user_email'];
	
	
	if(empty($_POST["headline"]))
		$headlineErr = "Headline is required !";
	else
		$headline = test_input($_POST["headline"]);
	
	if(empty($_POST["story"]))
		$storyErr = "Story is required !";
	else
		$story = test_input($_POST["story"]);

	if((!empty($_POST["name"])) && (!empty($_POST["email"]))&& 
	   (!empty($_POST["headline"]))&& (!empty($_POST["story"])) && 
	   (filter_var($email, FILTER_VALIDATE_EMAIL)))
	{
	
	$servername = "localhost";
	$username = "username";
	$dbpassword = "";
	$dbname = "gtdatabase";

    $connection = mysqli_connect($servername,$username,$dbpassword,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	else {
		$insert= "INSERT INTO channel_news (Channel_ID,Name,Email,Headline,Story,Date) 
				  VALUES('$channel','$name','$email','$headline','$story',NOW())";
		
		if(mysqli_query($connection,$insert))
		{
			echo "Data inserted to database successfully !<br>";
			mysqli_close($connection);
			header("Location: user.php"); //after saving data return to instructor page
			exit;
		}
		else
			die("Data insertion failed ! ". mysqli_error($connection));
		
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
<form name="add_announcement" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <table>
	<h3>Add Announcement for Channel <?php echo $channel?></h3>
    <tr> 
    <tr> 
      <td>Headline</td>
      <td><input name="headline" type="text" id="headline"></td>
	  <td><span style="color:red">* <?php echo $headlineErr; ?></span></td>
    </tr>
	
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr> 
      <td>News Story</td>
      <td><textarea name="story" id="story"></textarea></td>
	  <td><span style="color:red">* <?php echo $storyErr; ?></span></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center">
          <input name="hiddenField" type="hidden" value="add_n">
          <input name="add" type="submit" id="add" value="Submit">
        </div></td>
    </tr>
  </table>
  </form>
 </div>
</body>
</html>
