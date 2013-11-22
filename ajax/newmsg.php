<?php  

session_start();

include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){

$status = $_POST['status'];
$text = mysql_real_escape_string($_POST['text']);
$title = mysql_real_escape_string($_POST['title']);

if($text == "" || $title == ""){

	echo "All fields are required!";
}elseif(strlen($title) > 100){
	echo "The subject must be 100 characters or fewer (".strlen($title)." given)";
}elseif(strlen($text) > 1000){
	echo "The message text must be 1000 characters or fewer(".strlen($text)." given)";
}else{
	$query = mysql_query("INSERT INTO `default` (`status`, `title`, `text`) VALUES ('$status', '$title', '$text')");

	if(!$query){
		echo "There was a problem adding the new message: " . mysql_error();
	}else{
		echo "Message added! You may close this window, or add another message. <script> clearNewMsg(); getMsg();</script>";
	}
}


}