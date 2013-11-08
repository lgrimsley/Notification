<?
session_start();
if(!$_SESSION['admin']){
 echo "<script> window.location='admin.php' </script>";
}else{
	$userid = $_POST['id'];
	include("../functions.php");
	dbconnect();
	$query = mysql_query("DELETE FROM `users` WHERE `id`='$userid'");
	if(!$query){
		echo "Unable to delete user: ". mysql_error();
	}else{
		echo "<script> getPageData(); </script>";
	}

}
?>