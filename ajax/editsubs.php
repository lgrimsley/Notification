<?php

session_start();

include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){
$id = $_POST['id'];
$service = mysql_real_escape_string($_POST['service']);


if($service == "" ){
	echo "Input cannot be empty!";
}elseif(strlen($service) >= 25){
	echo "Input is too long. Must be 25 characters or less.";
}else{

	$query = mysql_query("UPDATE `services` SET `name`='$service' WHERE `id`='$id'");
	if(!$query){
		echo "There was a problem updating the database: ". mysql_error();
	}else{
		
			echo "<script>getSubs();</script>";
	}

}




}