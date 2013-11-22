<?php  

session_start();


if(isset($_SESSION['admin'])){
	include("../functions.php");

	dbconnect();
	if($_POST['getaddress']){

		$replyquery = mysql_query("SELECT `value` FROM `settings` WHERE `type`='replyto' AND `current`='yes'");
		if(mysql_num_rows($replyquery)){
			$replyto = mysql_result($replyquery,0);
		}else{
			$replyto = "alert@iglou.com";  //Default
			$replyquery = mysql_query("INSERT INTO `settings` (`type`,`value`,`current`) VALUES ('replyto','$replyto','yes')");
			if(!$replyquery){
				die("There was a problem creating a new entry in the database: " . mysql_error());
			}
		}
		$fromquery = mysql_query("SELECT `value` FROM `settings` WHERE `type`='from' AND `current`='yes'");
		if(mysql_num_rows($fromquery)){
			$from = mysql_result($fromquery,0);
		}else{
			$from = "alert@iglou.com";  //Default
			$fromquery = mysql_query("INSERT INTO `settings` (`type`,`value`,`current`) VALUES ('from','$from','yes')");
			if(!$fromquery){
				die("There was a problem creating a new entry in the database: " . mysql_error());
			}
		}

		echo "
		<script>
			$('#replyto').attr('value','$replyto');
			$('#fromaddress').attr('value','$from');
		 </script>
		 ";

	}else{

		$replyto = mysql_real_escape_string($_POST['replyto']);
		$from = mysql_real_escape_string($_POST['fromaddress']);

		if($replyto == "" || $from == ""){
			echo "All fields required!";
		}elseif(!check_email_address($replyto)){
			echo "Reply to address was improperly formatted. Must be a valid email address!";
		}elseif(!check_email_address($from)){
			echo "From address was improperly formatted. Must be a valid email address!";
		}elseif(strlen($replyto) > 50 || strlen($from) > 50){
			echo "A value entered had too many characters! Maximum of 50 each.";
		}else{

			$updatereply = mysql_query("UPDATE `settings` SET `value`='$replyto' WHERE `type`='replyto' AND `current`='yes'");
			$updatefrom= mysql_query("UPDATE `settings` SET `value`='$from' WHERE `type`='from' AND `current`='yes'");

			if(!$updatereply){
				die("Unable to update reply to address: ". mysql_error());
			}
			if(!$updatefrom){

				die("Unable to update frm address: ". mysql_error());

			}

			echo "Successfully updated addresses.";
		}


	}


}

?>