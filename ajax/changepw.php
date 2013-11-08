<?php
session_start();
include("../functions.php");
dbconnect();
if(isset($_SESSION['admin'])){

		$oldpw = $_POST['pwold'];
		$newpw = $_POST['pw1']; 
		$newpwc = $_POST['pw2'];

		$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='password' AND `current`='yes'");
		$password = mysql_fetch_assoc($query) or die(mysql_error());
		$password = array_pop($password);
		$goodtogo = false;

		if($oldpw == "" || $newpw == "" || $newpwc == ""){
			echo "All fields are required.";
		}elseif($oldpw == $newpw){
			echo "The new password is the same as the old password.";
		}elseif(md5($oldpw) != $password){
			echo "'Old Password' Incorrect. <br>";
		}elseif($newpw == ""){
			echo "You must enter a new password.";
		}elseif($newpw != $newpwc){
			echo "The new passwords do not match.";
		}elseif(!is_numeric($newpw)){
			echo "The new password must contain ONLY numbers.";
		}elseif(strlen($newpw) < 4 || strlen($newpw) > 8){
			echo "The new password must be between 4 and 8 characters";
		}else{

			$newpassword = md5($newpw);

			$remove = mysql_query("UPDATE `settings` SET `current`='no' WHERE `type`='password' AND `current`='yes'");  

			if(!$remove){ //Remove old password's usability, or tell us that you couldn't do it.
				echo "Unable to change password: Error removing old password.  " . mysql_error();
			}else{ //Add new password, make it usable
				$query = mysql_query("INSERT INTO `settings` (`type`, `value`, `current`) VALUES ('password', '$newpassword', 'yes') "); 
				if(!$query){
					echo "Unable to change password: Error adding new password. Please contact server administrator." . mysql_error();
				}else{

					echo "Success ";
				}
			}


		}






}else{
	echo "<script>window.location='http://www.google.com'</script>";
}

?>