<?php  

session_start();

include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){

$service = mysql_real_escape_string($_POST['service']);


if($service == ""){

	echo "All fields are required!";
}elseif(strlen($service) > 25){
	echo "The input must be 25 characters or fewer (".strlen($service)." given)";
}else{
	$query = mysql_query("INSERT INTO `services` (`name`, `active`) VALUES ('$service', '1')");

	if(!$query){
		echo "There was a problem adding the new message: " . mysql_error();
	}else{
		echo "<script>$('#newsubmodal').modal('toggle'); getsubs();</script>";
	}
}


}