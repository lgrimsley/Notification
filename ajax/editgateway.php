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
$name = mysql_real_escape_string($_POST['name']);  //Get the edited content, filter it.
$gateway = mysql_real_escape_string($_POST['gateway']);  //Get the edited content, filter it.


if($name == "" || $gateway == "" ){
	echo "Input cannot be empty!";
}elseif(strlen($name) >= 25){
	echo "Name is too long. Must be 25 characters or less.";
}elseif(strlen($gateway) >= 50){
	echo "Gateway is too long. Must be 50 characters or less.";
}elseif(strpos($gateway, "@") !== 0){
	echo "The first character in your gateway MUST be an @ symbol.";
}else{
 
	$query = mysql_query("UPDATE `providers` SET `name`='$name', `gateway`='$gateway' WHERE `id`='$id'");   //Update service with given ID
	if(!$query){
		echo "There was a problem updating the database: ". mysql_error();
	}else{
		
			echo "<script>getGatewayData();</script>";  //Refresh the page's content. 
	}

}




}