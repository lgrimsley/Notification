<?php 

include("template/header.php");

dbconnect(); 

//end header

$action = $_GET['a'];

$email = filter_input(INPUT_GET, 'Email', FILTER_SANITIZE_SPECIAL_CHARS);

$phone = filter_input(INPUT_GET, 'phoneUS', FILTER_SANITIZE_SPECIAL_CHARS);

$provider = filter_input(INPUT_GET, 'l_p', FILTER_SANITIZE_SPECIAL_CHARS);

$type = filter_input(INPUT_GET, 'l_t', FILTER_SANITIZE_SPECIAL_CHARS);

$phone = formatPhone($phone);

if(!$type) $type = $_POST['type'];

if(!$email) $email = $_POST['Email'];

if(!$email && $phone && $type ="Text") $email = formatEmail($phone, $provider);

$services = $_POST['services'];



if($action != "" && check_email_address($email)){

?> 

<center>
	<div  style=" width:100%; padding:0px; margin:0px;">

		<div class='well ' style="padding:0px; padding-bottom: 5%; text-align:left;width:100%; max-width:750px; min-width:305px;background-color:white; border-color:#eb9316; border: 3px;" >



<?

}



if($action == "unsubscribe"){

	unsubscribe($email);

} elseif($action == "add"){

	addEmail($email, $services, $phone, $provider, $type);

}elseif($action == "services"){

	if($type == "Text"){

		displayServices($email, $phone, $provider, $type);

	}else{

		displayServices($email, "", "" ,"Email");

	}

}else{

	include("template/emailform.php");

}



//footer

include("template/footer.php"); 

?>