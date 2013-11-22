<?php 

session_start();
	/*
	* This file very simply deletes a default message.
	* It is called via AJAX in the settings.php file. 
	* Search for this filename inside that file to locate.
	*/

if(!$_SESSION['admin']){

 echo "<script> window.location='admin.php' </script>";

}else{

	$id = $_POST['id'];  //Get the ID of what to delete

	include("../functions.php");

	dbconnect();

	$query = mysql_query("DELETE FROM `default` WHERE `id`='$id'");  //Delete it from the database

	if(!$query){

		echo "Unable to delete message: ". mysql_error();  //fail if we couldn't do it, and explain why.

	}


}

?>