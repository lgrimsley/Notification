<?php



function check_email_address($email) {

  // First, we check that there's one @ symbol, 

  // and that the lengths are right.

  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {

    // Email invalid because wrong number of characters 

    // in one section or wrong number of @ symbols.

    return false;

  }

  // Split it into sections to make life easier

  $email_array = explode("@", $email);

  $local_array = explode(".", $email_array[0]); 

  for ($i = 0; $i < sizeof($local_array); $i++) {

    if

(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&

↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",

$local_array[$i])) {

      return false;

    }

  }

  // Check if domain is IP. If not, 

  // it should be valid domain name

  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {

    $domain_array = explode(".", $email_array[1]);

    if (sizeof($domain_array) < 2) {

        return false; // Not enough parts to domain

    }

    for ($i = 0; $i < sizeof($domain_array); $i++) {

      if

(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|

↪([A-Za-z0-9]+))$",

$domain_array[$i])) {

        return false;

      }

    }

  }

  return true;

}



function dbconnect(){

	$hostname=  "localhost";

	$dbname = "grimsley_development";

	$dbuser = "grimsley_logan";

	$dbpw = "bigbang1";

	mysql_connect($hostname, $dbuser, $dbpw) or DIE(mysql_error());

	mysql_select_db($dbname) or die(mysql_error());

}


function appendString($string, $toappend, $charlimit){

	$strlen = strlen($string);
	$applen = strlen($toappend);
	if(($strlen + $applen)+2 <= $charlimit){
		$string .=  "\r\n" . $toappend;
	}else{

	$string = substr($string, 0, ($charlimit-$applen)-5);
	
	$string = $string . "..." . "\r\n" . $toappend;
	}
	if(strlen($string) <= $charlimit){
		return $string;
	}else return false;

}



function displayServices($email, $phone, $provider, $type){

	 $goahead = false;

		if($type == "Email"){

			if($email & !check_email_address($email)){

				echo "

				<div class='bs-docs-example'>

				  <div class='alert fade in'>

					<button type='button' class='close' data-dismiss='alert'>x</button>

					<center><strong>Please enter an email address!</strong> The email entered was invalid.

				  </div>
 
				</div>

				<br>";

				

			}else $goahead = true;	

		}elseif($type == "Text"){

			if($phone && $provider){

				if(strlen($phone) == 10 && is_numeric($phone)){

					$goahead = true;

				}else {

					$goahead = false;
						echo "2";
				}

				

			}

		}else{

				echo "1";

			$goahead = false;

		}

		

		if(!$goahead){include("template/emailform.php");}

			else{ include("template/services.php"); }

}

 

function addEmail($email, $services, $phone, $provider, $type){

	dbconnect();

	if(emailExists($email)){

		updateEmail($email, $services);

	} else{

		addNewEmail($email, $services);

	}

}

function formatEmail($phone, $provider){

	dbconnect();

	$query = mysql_query("SELECT `gateway` FROM `providers` WHERE `name`='$provider'")or die(mysql_error());

	$gateway = mysql_fetch_assoc($query);



	$email = $phone . $gateway['gateway'];

	

	return $email;

}

function formatPhone($phone){

	$remove = array("(",")"," ", "-");

	$phone = str_replace($remove,"", $phone);

	return $phone;

}

function emailExists($email){

	$query = mysql_query("SELECT `id` FROM `users` WHERE email='$email'");

	$id = mysql_fetch_row($query);

	if($id){ 

		return true;

	}else return false; 

}





function type($email){

	dbconnect();

	$domain = substr($email, strpos($email, "@"));

	$query = mysql_query("SELECT `gateway` FROM `providers` WHERE 1");

		while($g = mysql_fetch_array($query)){

		$gateways[] = $g[0];

		}

	

	if(in_array($domain, $gateways)){

		return "Text";

	}else return "Email";

}



function addNewEmail($email, $services){

	$type = type($email);

	if($services) {

		$servicelist = implode(",", $services);

		$query = mysql_query("INSERT INTO `users` (`email`,`services`,`type`) VALUES ('$email','$servicelist','$type')")or DIE("Unable to Subscribe: " . mysql_error() . "<br><br><b>Please contact Iglou customer support with the error message above");

		if($query){

			echo "

			<div class='col-md-12 '>

					<span class='page-header ' >

						<h2 class='col-md-offset-2'>You have successfully subscribed to the Iglou Early Alert System!

							<p class=''>

									<small >

										You will be alerted regarding the selections highlighted in <font color='orange' style='font-weight:bold'>orange</font> below.

									

								</small>

							</p>

						</h2>

					</span>

			</div> 

			";

			echo showSubscription($email, "disabled");

			echo "<center><br> You may close this window, or <a href='index.php?a=services&Email=$email'>Click here to change your subscription</a>";

			

		}

		

	} else{

		echo "You did not choose any services to be alerted about. <a href='index.php?a=services&Email=$email'>Click here</a> to select at least one service, or close this window if you do not wish to subscribe";

	}





}

function showSubscription($email, $disabled, $type = "services"){  //This function will return a variable with the HTML code for the subscription input. 

		if($email){ 						   					   //Disabled variable makes it uneditable, good for showing status of current email subscription.

			dbconnect();										   //Optional argument (type) accepts: 'up', 'info', 'down'. Defaults to services (user end), used for POST variable names.

			if($email == 'admin') {

				if(isset($_SESSION['alert']['services']) && $_SESSION['alert']['status'] == $type ){

					$userv = $_SESSION['alert']['services'];

					$slist = implode(",", $userv);

				}else	$userv = array(); 

			}elseif(emailExists($email)){

				$query = mysql_query("SELECT `services` FROM `users` WHERE `email`='$email'");

				$userv = mysql_fetch_row($query);

				$slist = $userv[0];

				$userv = explode(",",$userv[0]);

			} else {

				$userv = array(8);

				$slist = "";

			}

		

		} else $userv = array(8);

			$query = mysql_query("SELECT * FROM `services`");

					

			$c = 0;

			

			if($disabled != 'disabled') {

					

				$classes = "overbox btn box btn-lg";

				$allclass = " btn btn-default allbox btn-lg";

				if($slist == "1,2,3,4,5,6,7,8"){

					$checked = 'checked';

					$allclass = "btn btn-warning allbox btn-lg";

					$classes = "overbox btn btn-warning box btn-lg";

				}else{

					unset($checked);

				} 

				$html .= "<center><div class='boxes'>

				<div class='$allclass' style='padding:0px !important; height:2em !important;'  id='".$type."div' name='$type' >

					<span class='btntxt vmiddle'>

						<input type='checkbox'  style='display:none' $checked  id='$type'>

						All <i class='glyphicon glyphicon-retweet'></i> None

					</span>

				</div>";



				}else{

					$html .= "<center><div class='boxes'>";

					$classes = "btn box btntxt disabled ";

				}

				
 
			while($services = mysql_fetch_array($query)){

			

			$divid = $type . $c;

			$chkboxid = "x" . $type . $c;

			

				if(in_array($services['id'], $userv)){                                                                                                                                        

					$html .= "<button type='button' class='".$classes." btn-warning'  style='white-space: inherit;   height:50px;' id='$divid'>

					<span class='btntxt vmiddle'>". $services['name']. "</span>

					<input style='display:none' id='$chkboxid' type='checkbox' checked $disabled name='".$type."[]' value='" . $services['id']. "'>

					</button>";

				}else{

					$html .= "<button type='button' class='".$classes."  btn-default' style='white-space: inherit;height:50px;'  id='$divid' >

					<span class='btntxt vmiddle'>".$services['name']."</span>

					<input style='display:none' id='$chkboxid' type='checkbox' $disabled  name='".$type."[]' value='" . $services['id']. "'></button>";

				}

				 
 
				$c++;

			}	

			return $html;



}

function updateEmail($email, $services){

	if($services) {

		$servicelist = implode(",", $services);

		$query = mysql_query("UPDATE `users` SET `services`='$servicelist' WHERE `email` = '$email'")or DIE("Unable to Change Subscription: " . mysql_error() . "<br><br><b>Please contact Iglou customer support with the error message above");

		if($query){

			echo "

			<div class='col-md-12 '>

					<span class='page-header ' >

						<h2 class='col-md-offset-2'>Your subscription has been updated!

							<p class=''>

									<small >

										You will be alerted regarding the selections highlighted in <font color='orange' style='font-weight:bold'>orange</font> below.

									

								</small>

							</p>

						</h2>

					</span>

			</div> 

			";

		}

		echo showSubscription($email, "disabled");

		echo "<h2><small> You may close this window,<br> or <a href='index.php?a=services&Email=$email'>Click here to change your subscription</a></small></h2>";

		

	} else{

		unsubscribe($email);

	}



}



function unsubscribe($email){

	$query = mysql_query("DELETE FROM `users` WHERE `email`='$email'") or DIE("Unable to unsubscribe: " . mysql_error() . "<br><br><b>Please contact Iglou customer support with the error message above");

	if($query){	

		echo"

		<div class='col-md-12 '>

					<span class='page-header ' >

						<h2 class='col-md-offset-2'>You have successfully unsubscribed from the IgLou Early Warning system.

						</h2>

					</span>

			</div>";

			echo showSubscription("admin", "disabled");

			echo "<h2>

			<small >

					You may close this window, or <a href='index.php?a=services&Email=$email'>Click here to subscribe to alerts.</a>	

			</small>

			</h2>";

	}

}



function loadDefault($args = ""){  //This functions loads the defalt messages into an array.

	$query = mysql_query("SELECT * FROM `default` $args") or die(mysql_error());

	$i = 0;

	while($msg = mysql_fetch_array($query)){

		$default[$i] = $msg;

		$i++;

	}

	return $default;

	

}	



function getAdminUI($status){



$default = loadDefault("WHERE `status`='$status'");



include("template/adminui.php");



return $html;





}





function getAffected($affected, $method){              //Returns an array containing all of the users affected by alert

	$i=0;

	$users = array();

	$first = array_pop($affected);
	$method = array_pop($method);
	$firstmethod = array_pop($method);

	$first = $first['id'];

	$sql = "SELECT * FROM `users` WHERE ((`type`='$firstmethod'";


		foreach($method as $m){
			$sql .=" OR `type` ='".$m."'";
		}

	$sql .= ") AND  (FIND_IN_SET('$first', `services`) ";

	foreach($affected as $service){

		$id = $service['id'];

		$sql .= " OR FIND_IN_SET('$id', `services`)";

	}
		$sql .= "))";



	$query = mysql_query($sql) or die(mysql_error());

	while($u = mysql_fetch_array($query)){

		array_push($users, $u);

	}

	return $users;

}



?>