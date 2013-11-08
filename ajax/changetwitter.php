<?
session_start();

if(!$_SESSION['admin']){
 echo "<script> window.location='admin.php' </script>";
}else{
	include("../functions.php");
	dbconnect();

	if($_POST['getkeys']==true){

		$getkey = mysql_query("SELECT `value` FROM `settings` WHERE `type`='consumerkey' AND `current`='yes'");
		$consumerKey = mysql_result($getkey, 0);
		$getkey1 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='consumersecret' AND `current`='yes'");
		$consumerSecret = mysql_result($getkey1, 0);
		$getkey2 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='accesstoken' AND `current`='yes'");
		$accessToken = mysql_result($getkey2, 0);
		$getkey3 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='accesstokensecret' AND `current`='yes'");
		$accessTokenSecret = mysql_result($getkey3, 0);

		echo "<script>

		 $('#consumerKey').html('$consumerKey');
		 $('#consumerSecret').html('$consumerSecret');
		 $('#accessToken').html('$accessToken');
		 $('#accessTokenSecret').html('$accessTokenSecret');

		 </script>";


	}else{

		include("../twitter/twitter.class.php");

		$consumerKey = $_POST['consumerKey'];
		$consumerSecret = $_POST['consumerSecret'];
		$accessToken = $_POST['accessToken'];
		$accessTokenSecret = $_POST['accessTokenSecret'];

		

		if($consumerKey == "" || $consumerSecret == "" || $accessToken == "" || $accessTokenSecret == ""){
			echo "All fields are required!";
		}else{
			$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken , $accessTokenSecret);
			if(!$twitter->authenticate()){
				echo $twitter->authenticate();
				$msg =  "Testing... Failed. The codes entered are invalid";
			}
 
			
			if(!$msg){
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
						if($updated == true){
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
				echo $msg;
			}

		}	
		


	}
}


?>