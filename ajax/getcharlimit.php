<?php  

session_start();


if(isset($_SESSION['admin'])){
	include("../functions.php");

	dbconnect();
	if($_POST['getcharlimit']){

		$textquery = mysql_query("SELECT `value` FROM `settings` WHERE `type`='Textcharlimit' AND `current`='yes'");
		if(mysql_num_rows($textquery)){
			$textlimit = mysql_result($textquery,0);
		}else{
			$textlimit = 160;  //Default
			$textquery = mysql_query("INSERT INTO `settings` (`type`,`value`,`current`) VALUES ('Textcharlimit','$textlimit','yes')");
			if(!$textquery){
				die("There was a problem creating a new entry in the database: " . mysql_error());
			}
		}
		$twitterquery = mysql_query("SELECT `value` FROM `settings` WHERE `type`='Twittercharlimit' AND `current`='yes'");
		if(mysql_num_rows($twitterquery)){
			$tweetlimit = mysql_result($twitterquery,0);
		}else{
			$tweetlimit = 140;  //Default
			$twitterquery = mysql_query("INSERT INTO `settings` (`type`,`value`,`current`) VALUES ('Textcharlimit','$tweetlimit','yes')");
			if(!$twitterquery){
				die("There was a problem creating a new entry in the database: " . mysql_error());
			}
		}

		echo "<script>
			$('#textlimit').attr('value','$textlimit');
			$('#twitterlimit').attr('value','$tweetlimit');
		 </script>";

	}else{

		$textlimit = mysql_real_escape_string($_POST['textlimit']);
		$tweetlimit = mysql_real_escape_string($_POST['twitterlimit']);

		if(!is_numeric($textlimit) || !is_numeric($tweetlimit)){
			echo "Non-numeric values entered. Please try again";
		}elseif($textlimit == "" || $tweetlimit == ""){
			echo "All fields required! Remember, default values are 160 for Text messages, and 140 for Tweets.";
		}elseif(strlen($textlimit) > 3 || strlen($tweetlimit) > 3){

			echo "Value is too high!";
		}else{

			$updatetxt = mysql_query("UPDATE `settings` SET `value`='$textlimit' WHERE `type`='Textcharlimit' AND `current`='yes'");
			$updatetweet = mysql_query("UPDATE `settings` SET `value`='$tweetlimit' WHERE `type`='Twittercharlimit' AND `current`='yes'");

			if(!$updatetxt){
				die("Unable to update Text message character limit: ". mysql_error());
			}
			if(!$updatetweet){

				die("Unable to update Tweet character limit: ". mysql_error());

			}

			echo "Successfully updated character limits.";
		}


	}


}

?>