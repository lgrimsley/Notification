<?php

session_start();



if($_SESSION['admin'] == true && isset($_SESSION['alert'])){



include("../functions.php");

dbconnect();



		

$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='alerturl' AND `current`='yes'");

$alerturl = mysql_fetch_assoc($query) or die(mysql_error());

$alerturl = $alerturl['value'];

$alerturl = str_replace("[alert id]", $_SESSION['alert']['id'], $alerturl); 



$start = '<!--START--!>';



$end  = '<!--END--!>';



$tcount = 0; //Count of text messages sent

$tfcount = 0;//Texts failed

$ecount = 0; //Count of emails sent

$efcount = 0;//Emails failed

$fcount = 0; //Failed Messages

$twcount = 0; //Count of tweets sent

$twfcount = 0;//Count of tweets failed



$failed = array(); //store users that failed in this array for trimming later on.



// Always set content-type when sending HTML email







// More headers



$headers .= 'From: <alert@iglou.com>' . "\r\n";



$label = $_SESSION['alert']['label'];

		$squery = mysql_query("SELECT * FROM `services`") or die(mysql_error());

		$i = 0;
		$affected = array();
		$servicelist = array();

		while($serv = mysql_fetch_array($squery)){ //Compile all affect services into array

			if(in_array($serv['id'], $_SESSION['alert']['services'])){

				$affected[$i] = $serv;
				$servicelist[] = $serv['id'];

				$i++;

			}

		}





	if(in_array("Twitter",$_SESSION['alert']['method'][0])){



		include("../twitter/twitter.class.php");           //Twitter access keys, from twitter's dev site



		$getkey = mysql_query("SELECT `value` FROM `settings` WHERE `type`='consumerkey' AND `current`='yes'");

		$consumerKey = mysql_result($getkey, 0);

		$getkey1 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='consumersecret' AND `current`='yes'");

		$consumerSecret = mysql_result($getkey1, 0);

		$getkey2 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='accesstoken' AND `current`='yes'");

		$accessToken = mysql_result($getkey2, 0);

		$getkey3 = mysql_query("SELECT `value` FROM `settings` WHERE `type`='accesstokensecret' AND `current`='yes'");

		$accessTokenSecret = mysql_result($getkey3, 0);





		try {

		    $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken , $accessTokenSecret);

		} catch (TwitterException $e) {

		    $twerror = "Post to Twitter error: " . $e->getMessage();

		    $twfcount ++;

		}





		if($twitter->send($_SESSION['alert']['tweet'])){

			$twcount++;

		}else {$twfcount++;}





	}

			$txtmsg = formatMessage($_SESSION['alert']['status'], "Text", "", $_SESSION['alert']['id'], $_SESSION['alert']['message'], "", "", $_SESSION['alert']['subject'], $servicelist);

			$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='".$_SESSION['alert']['status']."Textformat' AND `current`='yes'");
			if(mysql_num_rows($query)){
				$format = mysql_result($query,0);
				if(in_array("services", explode(",", $format))){
					$txtflag = 1;

					$formatarray = explode("services,", $format); 
					$start = explode(",",$formatarray[0]);
					$end = explode(",",$formatarray[1]);
					if(($key = array_search("linkback", $end)) !== false) {
					    unset($end[$key]);
					}
					
					$toptext = formatMessage($_SESSION['alert']['status'], "Text", $start, $_SESSION['alert']['id'], $_SESSION['alert']['message'], "", "", $_SESSION['alert']['subject'], $servicelist);
					$bottomtext = formatMessage($_SESSION['alert']['status'], "Text", $end, $_SESSION['alert']['id'], $_SESSION['alert']['message'], "", "", $_SESSION['alert']['subject'], $servicelist);
				}
			}


foreach($_SESSION['users'] as $user){



	if($user['type'] == "Email"){

		$headers = "MIME-Version: 1.0" . "\r\n";



		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";



		$message = file_get_contents('../alertcontents.html');



 		$services = explode(",", $user['services']);



		$content = "<ul>";



		foreach($_SESSION['alert']['affected'] as $s){



			if(in_array($s['id'], $services)){



				$content .= "<li><span class='label $label' style='width:135px;'>".$s['name']." </span></li> ";



				$i++;



				//if($i==2){ $i=0; $content .="<br>";}



			}



		}

			$content .= "</ul>";



		



	$message = preg_replace('#(<!--SURL-->)(.*)(<!--EURL-->)#si', "<a href='http://lgrimsley.com/alert/index.php?a=unsubscribe&Email=".$user['email']."'>Click Here</a>", $message);

	$message = preg_replace('#('.$start.')(.*)('.$end.')#si', $content, $message);


	if(mail($user['email'],$_SESSION['alert']['subject'],$message, $headers, '-falert@iglou.com')){

							

				$ecount++;



			}else{





					$efcount++;

					$fcount++;



					//$failed[] = $user;



				}
	



	}else{

		if($txtflag){

			$middle = "";

			$services = explode(",",$user['services']);

			foreach($_SESSION['alert']['affected'] as $s){

			if(in_array($s['id'], $services)){

				if($s['name'] != 'Announcements'){ 
							$middle .= $s['name']."\r\n";
						}
			}

		}

			$message = $toptext .  $middle .  $bottomtext;
			$message = appendString($message, $alerturl, "Text");

		}else{
			$message = $txtmsg;
		}




		if(mail($user['email'],"",$message, $headers, '-falert@iglou.com')){



					$tcount++;



				}else{



					$fcount++;

					$tfcount++;



					//$failed[] = $user;



				}

	

		



	}
}


				

  

	$totalcount = $tcount + $fcount + $ecount;

	

	//Report the results



     echo " <table class='table table-striped'>

        <thead>

          <tr>

            <th>Success</th>

            <th>Fail</th>

            <th>Type</th>

            <th>View</th>

          </tr>

        </thead>

        <tbody>

          <tr>

            <td>" . $totalcount ."</td>

           	<td>$fcount</td>

            <td>Total</td>

            <td><a class='btn btn-sl btn-info' style='width:100px' href='http://lgrimsley.com/alert/a/?i=" . $_SESSION['alert']['id'] ."'>View Alert</a></td>

          </tr>	

          <tr>

            <td>$ecount</td>

            <td>$efcount</td>

            <td>Email</td>

            <td><a class='btn btn-sl btn-info' style='width:100px' href='http://lgrimsley.com/alert/a/?i=" . $_SESSION['alert']['id'] ."'>View Email</a></td>

          </tr>

          <tr>

            <td>$tcount</td>

            <td>$tfcount</td>

            <td>Text</td>

            <td><a class='btn btn-sl btn-info' style='width:100px' href='http://lgrimsley.com/alert/a/?t=txt&i=" . $_SESSION['alert']['id'] ."'>View Text</a></td>

          </tr>

          <tr>

          <td>$twcount</td>

          <td>$twfcount</td>

           <td>Tweet</td>

           <td><a class='btn btn-sl btn-info' style='width:100px' href='http://twitter.com/iglou'>View Twitter</a></td>

          </tr>

        </tbody>

      </table>";

      if($twfcount > 0){

	      echo "

		      <div>

		      	$twerror

		      </div>

		      ";

      }

      



				unset($_SESSION['alert']);

				unset($_SESSION['users']);



}

  ?>

