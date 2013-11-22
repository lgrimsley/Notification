<?php 

session_start();
	/*
	* This file DOES NOT DELETE subscription items - it simply disables them.
	* I did this because people may still be subscribed to it, and if we need to re-enable it we can do so.
	* It is called via AJAX in the settings.php file. 
	* Search for this filename inside that file to locate.
	*/
if(!$_SESSION['admin']){

 echo "<script> window.location='admin.php' </script>";

}else{

	$id = $_POST['id'];

	include("../functions.php");

	dbconnect();

	$query = mysql_query("UPDATE `services` SET `active`='0' WHERE `id`='$id'");    //Set the selected ID as inactive.

	if(!$query){

		echo "Unable to delete message: ". mysql_error();

	}


}

?>