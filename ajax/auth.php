<?php


	include("../functions.php");
	dbconnect();
	$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='password' AND `current`='yes'");
	$password = mysql_fetch_assoc($query);
	$password = array_pop($password);
	if(!$password){					//If password is removed from database for some reason, default password will be 0000
		$password = md5("0000");
	}


	if(md5($_POST['val']) == $password){
		session_start();
		$_SESSION['admin'] = true;
		echo "<script>window.location='admin.php'</script>";
	}


?>