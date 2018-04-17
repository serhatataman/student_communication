<?php 
if(!isset($_SESSION)) 
        session_start();  
?>
<!DOCTYPE html>
<html>
<title>CEN DEPARTMENT</title>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="fonts/navigation_bar_font.css">
<link rel="stylesheet" type="text/css" href="fonts/sidebar_fonts.css">
<link rel="stylesheet" type="text/css" href="fonts/middle_area_fonts.css">
<link rel="stylesheet" type="text/css" href="fonts/right_side_ann_fonts.css">

<style>
body {margin:0;}
</style>
</head>
<body>
     <!--/*Navigation bar*/-->
	 <!--/*fonts are in stylesheet*/-->
<nav class="navbar"> 
  <a href="/gt/user.php" class="ceng">COMPUTER ENGINEERING DEPARTMENT</a>  <!--/*when user clicks a channel after that wants to back to his/her main page, we should use session*/-->
  <a href="/gt/logout.php" style="background-color: #cc0000;">Logout</a>
  <a href="#profile">Profile</a>
  <a href="#contact">Contact</a>
  <a href="/gt/user.php">Home</a>
</nav>

	<!--/*Side bar*/-->

<div class="sidebar">
  <h2 style="text-align:center;">Channels</h2>
  <?php
	require 'fetch_channel_id_for_sidebar.php';
  ?>
  <br>
  <?php
		if($_SESSION['user_type']=="student")
		{
			echo '<a href="/gt/join_channel.php">Join Channel</a>';
			echo '<a href="/gt/received_mails.php">Inbox</a>';
		}
		else
		{
			echo '<a href="/gt/add_channel_announcement.php">Add Announcement for Channel</a>
				  <a href="/gt/create_channel.php">Create Channel</a>
				  <a href="/gt/send_email.php">Send E-mail</a>';
		}
  ?>
  </div>

	<!--Middle area-->
	
<div class="middlea">
	<div>
		<div>
		
			<h2><?php echo $_GET['channel_id'];?> Announcements</h2>
			<?php 
				$_SESSION['channel_id']=$_GET['channel_id'];
				require 'fetch_channel_announcement.php';
			?>
			
		</div>
	</div>
	<br><br><br>
	<div>
		<div>
			<!--
			<h1 >Files</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
			Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			-->
		</div>
	</div>
	<br><br><br>
</div>
	
</body>
</html>


















