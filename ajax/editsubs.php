<?php  

session_start();
	/*
	* This file applies the edit made to the given subscription.
	* It is called via AJAX in the settings.php file. 
	* Search for this filename inside that file to locate.
	*/
include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){
$id = $_POST['id'];   //Get ID from page
$service = mysql_real_escape_string($_POST['service']);  //Get the edited content, filter it.


if($service == "" ){
	echo "Input cannot be empty!";
}elseif(strlen($service) >= 25){
	echo "Input is too long. Must be 25 characters or less.";
}else{
 
	$query = mysql_query("UPDATE `services` SET `name`='$service' WHERE `id`='$id'");   //Update service with given ID
	if(!$query){
		echo "There was a problem updating the database: ". mysql_error();
	}else{
		
			echo "<script>getSubs();</script>";  //Refresh the page's content. 
	}

}




}