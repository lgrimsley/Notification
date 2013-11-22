<?php 

session_start();

	/*
	* This file changes the link-back URL. 
	* It is called via AJAX in the settings.php file. 
	* Search for this filename inside that file to locate.
	*/

if(!$_SESSION['admin']){

 echo "<script> window.location='admin.php' </script>";

}else{

include("../functions.php");

dbconnect();



if(isset($_POST['view'])){       //This returns the current link back.

	$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='alerturl' AND `current`='yes'");

	$alerturl = mysql_fetch_assoc($query) or die(mysql_error());



	$alerturl = $alerturl['value']; 



	echo $alerturl;



}else{  //If we aren't displaying the value, we must be trying to change it. 







$text = mysql_real_escape_string($_POST['text']);  //retrieve entered values

$url = mysql_real_escape_string($_POST['url']);

$alertid = "?i=[alert id]";  //This is the standard alert ID format that we will enter into the database.

$url = str_replace(" ", "", $url);  //Remove any added whitespace, it's a URL after all.



if($url == ""){ //Check to see if a URL was entered. 

	echo "You must enter a URL!";

}elseif((strlen($text) + strlen($url) + 3) >= 141){  // Check to see the total length of the string combined. 
													 //Has to be 140 characters or less to work with twitter and SMS.

	echo "The entered values would take up more than the entire text/tweet. Total length must be 140 characters or less.";

}else{

	$value = $text ." ". $url . $alertid;  //Combine the values and create the new link back string

	$delete = mysql_query("UPDATE `settings` SET `current`='no' WHERE `type`='alerturl' AND `current`='yes'");

	if(!$delete){

		echo "There was a problem modifying the database: " . mysql_error();

	}else{

		$query = mysql_query("INSERT INTO `settings` (`type`, `value`, `current`) VALUES ('alerturl', '$value', 'yes')");

			if(!$query){



				echo "There was a problem updating the link-back text: " . mysql_error();

			}else{

				echo "Success ";

			}

	}

	



}



}









}



?>