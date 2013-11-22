<?php 

session_start();
	/*
	* This file removes gateways from the database.
	* It is called via AJAX in the getgateway.php file. 
	* Search for this filename inside that file to locate.
	*/
if(!$_SESSION['admin']){

 echo "<script> window.location='admin.php' </script>";

}else{

	$id = $_POST['id'];

	include("../functions.php");

	dbconnect();

	$query = mysql_query("DELETE FROM `providers` WHERE `id`='$id'");  //Delete it from the database

	if(!$query){

		echo "Unable to delete message: ". mysql_error();

	}


}

?>