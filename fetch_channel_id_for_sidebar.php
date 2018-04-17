<?php  
	
	if(!isset($_SESSION))
		session_start();
	
	$servername = "localhost";
	$username = "username";
	$password = "";
	$dbname = "gtdatabase";
	
	$connection = mysqli_connect($servername,$username,$password,$dbname);
	if(!$connection)
		die("Database connection failed: " . mysqli_connect_error());
	
	if($_SESSION['user_type']=="instructor"){
		
		$current_user = $_SESSION['user_id'];
		$query = "SELECT ID FROM channel WHERE Owner_ID='$current_user'";
		
		if($result = mysqli_query($connection,$query))
		{
			while($id=mysqli_fetch_assoc($result))
			{
				echo '<a href="channel_info.php?channel_id='.$id['ID'].'">'.$id['ID'].'</a>';
				/*
					channel_info ya tıklanılan kanalın id sini gönderir. 
					böylelikle istenilen kanalın haber akışı bir sonraki sayfanın
					middle area'sında gösterilir. (çok uğraştım :)  )
				*/
			}
			mysqli_free_result($result);
		
		}
	}
	
	else { //if it is STUDENT
		$current_user = $_SESSION['user_id'];
		$query = "SELECT Channel_ID FROM student_channel WHERE Student_ID='$current_user'";
		
		if($result = mysqli_query($connection,$query))
		{
			while($id=mysqli_fetch_assoc($result))
			{
				echo '<a href="channel_info.php?channel_id='.$id['Channel_ID'].'">'.$id['Channel_ID'].'</a>';
			} 
		mysqli_free_result($result);
		
		}
	}
	mysqli_close($connection);
/*
	21. satırda linkleri aldıktan sonra . her bir link için verilerin
	middle area 'ya yazdırılması lazım.
*/
?>