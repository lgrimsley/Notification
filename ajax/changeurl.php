<?
session_start();

if(!$_SESSION['admin']){
 echo "<script> window.location='admin.php' </script>";
}else{
include("../functions.php");
dbconnect();

if(isset($_POST['view'])){
	$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='alerturl' AND `current`='yes'");
	$alerturl = mysql_fetch_assoc($query) or die(mysql_error());

	$alerturl = $alerturl['value']; 

	echo $alerturl;

}else{



$text = mysql_real_escape_string($_POST['text']);
$url = mysql_real_escape_string($_POST['url']);
$alertid = "?i=[alert id]";
$url = str_replace(" ", "", $url);

if($url == ""){
	echo "You must enter a URL!";
}elseif((strlen($text) + strlen($url) + strlen($alertid)) >= 141){
	echo "The entered values would take up more than the entire text/tweet. Total length must be 140 characters or less.";
}else{
	$value = $text ." ". $url . $alertid;
	$delete = mysql_query("UPDATE `settings` SET `current`='no' WHERE `type`='alerturl' AND `current`='yes'");
	if(!$delete){
		echo "There was a problem modifying the database: " . mysql_error();
	}else{
		$query = mysql_query("INSERT INTO `settings` (`type`, `value`, `current`) VALUES ('alerturl', '$value', 'yes')");
			if(!$query){

				echo "There was a problem updating the link-back text: " . mysql_error();
			}else{
				echo "Success ";
			}
	}
	

}

}




}

?>