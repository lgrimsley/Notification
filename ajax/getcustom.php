<?php

session_start();


if(isset($_SESSION['admin'])){
	include("../functions.php");

	dbconnect();
	$type = $_POST['type'];
	$status = $_POST['status'];

	$tquery = mysql_query("SELECT `value` FROM `settings` WHERE `type`='".$status.$type."title' AND `current`='yes'");
	if(mysql_num_rows($tquery)){
		$title = mysql_result($tquery, 0);
	}else{
		$title = "";
		$tquery = mysql_query("INSERT INTO `settings` (`type`,`value`,`current`) VALUES ('".$status.$type."title','','yes')");
		if(!$tquery) echo "There was an error creating a new databse entry: " . mysql_error();
	}

	$fquery = mysql_query("SELECT `value` FROM `settings` WHERE `type`='".$status.$type."footer' AND `current`='yes'");
	if(mysql_num_rows($fquery)){
		$footer = mysql_result($fquery, 0);
	}else{
		$footer = "";
		$fquery = mysql_query("INSERT INTO `settings` (`type`,`value`,`current`) VALUES ('".$status.$type."footer','','yes')");
		if(!$fquery) echo "There was an error creating a new databse entry: " . mysql_error();
	}

	echo "
	<script>
	$('#inputtitle').attr('value', '$title');
	$('#inputfooter').attr('value', '$footer');
	</script>
	";
}
?>