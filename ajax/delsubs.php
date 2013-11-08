<?

session_start();

if(!$_SESSION['admin']){

 echo "<script> window.location='admin.php' </script>";

}else{

	$id = $_POST['id'];

	include("../functions.php");

	dbconnect();

	$query = mysql_query("UPDATE `services` SET `active`='0' WHERE `id`='$id'");

	if(!$query){

		echo "Unable to delete message: ". mysql_error();

	}


}

?>