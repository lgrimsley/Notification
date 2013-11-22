<?php  

session_start();


if(isset($_SESSION['admin'])){
	include("../functions.php");

	dbconnect();

	$type = $_POST['type'];
	$status = $_POST['status'];	

	if($_POST['format']){
		$format = $_POST['format'];
	}else{

		
		$fquery = mysql_query("SELECT `value` FROM `settings` WHERE `type`='".$status.$type."format' AND `current`='yes'");
		if(mysql_num_rows($fquery)){
			$format = mysql_result($fquery,0);
			if($format == "") {
				$format =  "subject,services,linkback";
			}
		}else{ 
			$q = mysql_query("UPDATE `settings` SET `value`='subject,services,linkback' WHERE `type`='".$status.$type."format' AND `current`='yes'"); 
			if(!$q) echo "There is a problem with the database. IgLou Error code 2921";
		} 

		$format = explode(",",$format);
	}

	if($_POST['format']){
		$format = $_POST['format'];
		$saveformat = implode(",",$format);
		$query = mysql_query("UPDATE `settings` SET `value`='$saveformat' WHERE `type`='".$status.$type."format' AND `current`='yes'");
		if(!$query) echo "There was a problem updating the database: ". mysql_error();

	}elseif(!$_POST['format'] && !$_POST['customtitle'] && !$_POST['customfooter']){

		echo "You must select at least one attribute. Changes were not saved.";
		$halt = true;
	}
		if($_POST['customtitle'] != "" && $_POST['customtitle']){
			$title = mysql_real_escape_string($_POST['customtitle']);
			$query = mysql_query("UPDATE `settings` SET `value`='$title' WHERE `type`='".$status.$type."title' AND `current`='yes'");
				if(!$query) die("There was a problem updatng the database: " . mysql_error());
		}

		if($_POST['customfooter'] != "" && $_POST['customfooter']){
			$footer = mysql_real_escape_string($_POST['customfooter']);
			$query = mysql_query("UPDATE `settings` SET `value`='$footer' WHERE `type`='".$status.$type."footer' AND `current`='yes'");
				if(!$query) die("There was a problem updatng the database: " . mysql_error());
		}

		if(!$title){
			$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='".$status.$type."title' AND `current`='yes'");
			if(mysql_num_rows($query)){
				$title = mysql_result($query,0);	
			}else{ $title = "";}
		}
		if(!$footer){
			$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='".$status.$type."footer' AND `current`='yes'");
			if(mysql_num_rows($query)){
				$footer = mysql_result($query,0);	
			}else{ $footer = "";}
		}
		
		if(!$halt){
		
			$message = formatMessage($status, $type, $format, 1, "", $title, $footer, "");

			echo $message;
		}
	


}else{
	echo "Your session has expired. You must login again to access this page <a href='admin.php'>(Click Here)</a>";
}


?>