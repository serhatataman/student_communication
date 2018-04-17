<!DOCTYPE html>
<html>
<title>CEN DEPARTMENT</title>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="fonts/middle_area_fonts.css">
<link rel="stylesheet" type="text/css" href="fonts/navigation_bar_font.css">
<link rel="stylesheet" type="text/css" href="fonts/sidebar_fonts.css">

<style>
body {margin:0;}
</style>
</head>
<body>
     <!--/*Navigation bar*/-->
	 <!--/*fonts are in stylesheet*/-->
<nav class="navbar"> 
  <a href="/gt/main_menu.php" class="ceng">COMPUTER ENGINEERING DEPARTMENT</a>
  <a href="/gt/signup.php" class="signup">Sign Up</a>
  <a href="/gt/login.php">Login</a>
  <a href="/gt/contact.php">Contact</a>
  <a href="/gt/main_menu.php">Home</a>
</nav>

	<!--There is no sidebar for people who are not logged in-->

	<!--Middle area-->
	
<div class="middlea">
	<div>
		<div>
			
			<?php
				require 'fetch_general_announcement.php';
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

















