<?php 

session_start();
	/*
	* This file very simply deletes a user.
	* It is called via AJAX in the settings.php file. 
	* Search for this filename inside that file to locate.
	*/
if(!$_SESSION['admin']){

 echo "<script> window.location='admin.php' </script>";

}else{

	$userid = $_POST['id'];

	include("../functions.php");

	dbconnect();

	$query = mysql_query("DELETE FROM `users` WHERE `id`='$userid'");  //Delete the given user from the database.

	if(!$query){

		echo "Unable to delete user: ". mysql_error();

	}else{

		echo "<script> getPageData(); </script>";  //Refresh the data on return.

	}



}

?>