<?php

	if(!isset($_SESSION))
		session_start();

	// remove all session variables
		session_unset(); 

	// destroy the session 
		session_destroy(); 
		
		header("Location: main_menu.php");
		exit;
?>