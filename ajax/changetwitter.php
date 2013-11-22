<?php 

session_start();

	/*
	* This file both retrieves and changes the twitter codes.
	* It is called via AJAX in the settings.php file. 
	* Search for this filename inside that file to locate.
	*/


if(!$_SESSION['admin']){  //If not logged in, forward back to login screen.

 echo "<script> window.location='admin.php' </script>";

}else{

	include("../functions.php");

	dbconnect();



	if($_POST['getkeys']==true){  //If we're just loading the page, get the twiter codes to display



		$getkey = mysql_query("SELECT `value` FROM `settings` WHERE `type`='consumerkey' AND `current`='yes'");

		$consumerKey = mysql_result($getkey, 0);

		$getkey1 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='consumersecret' AND `current`='yes'");

		$consumerSecret = mysql_result($getkey1, 0);

		$getkey2 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='accesstoken' AND `current`='yes'");

		$accessToken = mysql_result($getkey2, 0);

		$getkey3 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='accesstokensecret' AND `current`='yes'");

		$accessTokenSecret = mysql_result($getkey3, 0);


		//Display current twitter codes to their designated locations.
		echo "<script>    



		 $('#consumerKey').html('$consumerKey');

		 $('#consumerSecret').html('$consumerSecret');

		 $('#accessToken').html('$accessToken');

		 $('#accessTokenSecret').html('$accessTokenSecret');



		 </script>";





	}else{  //If we're not retrieving the codes, we must be attempting to store new ones



		include("../twitter/twitter.class.php");  //This file has all of the twitter auth stuff. 



		$consumerKey = $_POST['consumerKey'];  //assign posted variables to known variables

		$consumerSecret = $_POST['consumerSecret'];

		$accessToken = $_POST['accessToken'];

		$accessTokenSecret = $_POST['accessTokenSecret'];



		



		if($consumerKey == "" || $consumerSecret == "" || $accessToken == "" || $accessTokenSecret == ""){

			echo "All fields are required!";

		}else{

			$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken , $accessTokenSecret);

			if(!$twitter->authenticate()){

				echo $twitter->authenticate();  //Test the codes and see if they work. Store the error in a variable if there is one.

				$msg =  "Testing... Failed. The codes entered are invalid";

			}

 

			

			if(!$msg){  //Set old twitter codes inactive if the new ones work. Fail if there is some kind of problem doing so.

				$delete = mysql_query("UPDATE `settings` SET `current`='no' WHERE `type`='consumerkey' AND `current`='yes'");

					if(!$delete){

						echo "There was an error updating the database: " .mysql_error();

					}else{

						$delete = mysql_query("UPDATE `settings` SET `current`='no' WHERE `type`='consumersecret' AND `current`='yes'");

							if(!$delete){

								echo "There was an error updating the database: " .mysql_error();

							}else{ 

								$delete = mysql_query("UPDATE `settings` SET `current`='no' WHERE `type`='accesstoken' AND `current`='yes'");

								if(!$delete){

									echo "There was an error updating the database: " .mysql_error();

								}else{



									$delete = mysql_query("UPDATE `settings` SET `current`='no' WHERE `type`='accesstokensecret' AND `current`='yes'");

									if(!$delete){

										echo "There was an error updating the database: " .mysql_error();

									}else{



										$updated = true;



									}

								}

							}

						}

						if($updated == true){  //If we've been successful so far, insert the new twitter codes into the database.

							$query = mysql_query("INSERT INTO `settings` (`type`, `value`, `current`) VALUES ('consumerkey', '$consumerKey', 'yes')");

							if(!$query){

								echo "There was an error updating the database: " .mysql_error();

							}else{

								$query = mysql_query("INSERT INTO `settings` (`type`, `value`, `current`) VALUES ('consumersecret', '$consumerSecret', 'yes')");

								if(!$query){

									echo "There was an error updating the database: " .mysql_error();

								}else{

									$query = mysql_query("INSERT INTO `settings` (`type`, `value`, `current`) VALUES ('accesstoken', '$accessToken', 'yes')");

									if(!$query){

										echo "There was an error updating the database: " .mysql_error();

									}else{

										$query = mysql_query("INSERT INTO `settings` (`type`, `value`, `current`) VALUES ('accesstokensecret', '$accessTokenSecret', 'yes')");

										if(!$query){

											echo "There was an error updating the database: " .mysql_error();

										}else{

												echo "Success ";

										}

									}

								}

							}

						}

				

					

				

					



			}else{
					//Return the results. 
				echo $msg;

			}



		}	

		





	}

}





?>