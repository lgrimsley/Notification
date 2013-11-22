<?php  
	/*
	* This file authorizes the admin password entered at the calc screen.
	* It is called via AJAX in the template/adminlogin.php file
	*/

	include("../functions.php"); //Include the functions file.
	dbconnect(); //Connect to database

	 //Select the current password from database
	$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='password' AND `current`='yes'"); 
	$password = mysql_fetch_assoc($query);
	$password = array_pop($password);
	if(!$password){					//If password is removed from database for some reason, default password will be 0000
		$password = md5("0000");
	}


	if(md5($_POST['val']) == $password){      //Check password hash against entered value's hash. If it's the same,
											  // assign session variable and set true. User is then logged in.
		session_start();
		$_SESSION['admin'] = true;
		echo "<script>window.location='admin.php'</script>";   //Returns the javascript command to change the page, 
															   //effectively refreshing and showing the main menu.
	}


?>