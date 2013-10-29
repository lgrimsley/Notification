<?php
session_start();

if(isset($_SESSION['admin'])){
$hostname=  "localhost";

$dbname = "grimsley_development";

$dbuser = "grimsley_logan";

$dbpw = "bigbang1";

mysql_connect($hostname, $dbuser, $dbpw) or DIE(mysql_error());

mysql_select_db($dbname) or die(mysql_error());

$message = mysql_real_escape_string($_SESSION['alert']['message']);
$subject = mysql_real_escape_string($_SESSION['alert']['subject']);
$status = $_SESSION['alert']['status'];
$services = implode(",", $_SESSION['alert']['services']);
$method = implode(",",$_SESSION['alert']['method'][0]);

    $id = $_SESSION['alert']['id'];

    $query = mysql_query("UPDATE `alerts`  SET `subject`='$subject', `services`='$services', `message`='$message', `method`='$method', `status`='$status'  WHERE `id` = '$id'");

    if(!$query){ 
        echo "Error: " . mysql_error();
    }else{

        //Do some quick database maintainence

        $delete = mysql_query("DELETE FROM `alerts` WHERE `subject`='placeholder'");
        if(!$delete){
            echo "Error clearing database." . mysql_error();
        }

        echo "<script> $('#confirm').modal('toggle')</script>";
}
        

}else{
    echo "<script>window.location='http://www.google.com'</script>";
}


?>