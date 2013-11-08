<?php

session_start();

include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){
$id = $_POST['id'];
$text = mysql_real_escape_string($_POST['text']);
$title = mysql_real_escape_string($_POST['title']);


if($title == "" || $text == ""){
	echo "Subject and/or text body cannot be empty!";
}elseif(strlen($title) >= 100){
	echo "Subject is too long. Must be 100 characters or less (Attempted: " . strlen($title) . ")";
}elseif(strlen($text) > 1000){

	echo "Text body is too long. Must be 1000 characters or less (Attempted: " . strlen($text) . ")";
}else{

	$query = mysql_query("UPDATE `default` SET `title`='$title', `text`='$text' WHERE `id`='$id'");
	if(!$query){
		echo "There was a problem updating the database: ". mysql_error();
	}else{
		
			echo "<script>getMsg();</script>";
	}

}




}