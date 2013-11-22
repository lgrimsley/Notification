<?php  

session_start();

include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){

$name = mysql_real_escape_string($_POST['name']);  //Get the edited content, filter it.
$gateway = mysql_real_escape_string($_POST['gateway']);  //Get the edited content, filter it.


if($name == "" || $gateway == "" ){
	echo "Input cannot be empty!";
}elseif(strlen($name) >= 25){
	echo "Name is too long. Must be 25 characters or less.";
}elseif(strlen($gateway) >= 50){
	echo "Gateway is too long. Must be 50 characters or less.";
}elseif(strpos($gateway, "@") !== 0){
	echo "The first character in your gateway MUST be an @ symbol.";
}else{
	$query = mysql_query("INSERT INTO `providers` (`name`, `gateway`) VALUES ('$name', '$gateway')");

	if(!$query){
		echo "There was a problem adding the new message: " . mysql_error();
	}else{
		echo "<script>getGatewayData();</script>";
	}
}


}