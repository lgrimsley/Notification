<?php  

session_start();   //Continue session.

	/*
	* This file changes the password.
	* It is called via AJAX in the settings.php file. 
	* Search for this filename inside that file to locate.
	*/

include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){   //Only perform action if session still valid.



		$oldpw = $_POST['pwold'];      //Get variables from form

		$newpw = $_POST['pw1']; 

		$newpwc = $_POST['pw2'];


 
		$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='password' AND `current`='yes'");  //Get current password from database

		$password = mysql_fetch_assoc($query) or die(mysql_error());

		$password = array_pop($password); //Get only the password part of the returned array.

		//The following group of if statements ensures that the password meets all requirements. 

		if($oldpw == "" || $newpw == "" || $newpwc == ""){   //Fields can't be blank

			echo "All fields are required.";

		}elseif($oldpw == $newpw){  //Password can't be the same.

			echo "The new password is the same as the old password.";

		}elseif(md5($oldpw) != $password){   //If the old password doesn't match the stores old password.

			echo "'Old Password' Incorrect. <br>";

		}elseif($newpw != $newpwc){      //New password fields don't match

			echo "The new passwords do not match.";

		}elseif(!is_numeric($newpw)){  //Has to be a number

			echo "The new password must contain ONLY numbers.";

		}elseif(strlen($newpw) < 4 || strlen($newpw) > 8){  //Has to be between 4 and 8 digits.

			echo "The new password must be between 4 and 8 characters";

		}else{ //Continue!



			$newpassword = md5($newpw);    //hash the new password


			//Update the database and set the old password to be inactive (current = no, it won't be used.)

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













}else{  //If not logged in, send user far far away. 

	echo "<script>window.location='http://www.google.com'</script>";

}



?>