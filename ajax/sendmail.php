<?php
session_start();

if($_SESSION['admin'] == true && isset($_SESSION['alert'])){

include("../functions.php");
dbconnect();

		//IMPORTANT
		//The following will be appended to each text/tweet send to link back to the alert. 
		//Edit this if the hostname or alert location changes

		$alerturl = "Visit www.lgrimsley.com/alert/a/?i=" . $_SESSION['alert']['id'] . " for more info"; 

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
$services = array();


	if(in_array("Twitter",$_SESSION['alert']['method'][0])){

		include("../twitter/twitter.class.php");           //Twitter access keys, from twitter's dev site

		$consumerKey = "WvxNbVMQLNRSVYnWQI0I5Q";
		$consumerSecret = "XPTIHZPo4QdHJoYb0MS8NQrJhOKs27Q1V4thDEzZg8";
		$accessToken = "111494861-mn6H8QDwYiT1QBW52Wjuzt41FznJsXP38t5AgPMA";
		$accessTokenSecret = "LN5gbRiCKkmofEpf26JihihQ6iGiSkGfiRnzQrD8pUt0W";

		try {
		    $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken , $accessTokenSecret);
		} catch (TwitterException $e) {
		    $twerror = "Error: " . $e->getMessage();
		    $twfcount ++;
		}


		if($twitter->send($_SESSION['alert']['tweet'])){
			$twcount++;
		}else {$twfcount++;}


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

		

	$message = preg_replace('#(<!--SURL-->)(.*)(<!--EURL-->)#si', "<a href='http://lgrimsley.com/alert/index.php?a=unsubscribe&email=".$user['email']."'>Click Here</a>", $message);
	$message = preg_replace('#('.$start.')(.*)('.$end.')#si', $content, $message);

	}else{


		$squery = mysql_query("SELECT * FROM `services`") or die(mysql_error());

		$i = 0;
		$affected = array();
		
		while($serv = mysql_fetch_array($squery)){ //Compile all affect services into array

			if(in_array($serv['id'], $_SESSION['alert']['services'])){

				$affected[$i] = $serv;

				$i++;

			}

		}
			if($_SESSION['alert']['status'] == "down"){
					$message = "IgLou Outage Affecting:" . "\r\n";
					foreach($affected as $s){
					if($s['name'] != 'Announcements'){ 

						$message .= "".$s['name']."
";
					}

				}
			}elseif($_SESSION['alert']['status'] == "up"){
				$message = $_SESSION['alert']['subject'] . "\r\n" . $_SESSION['alert']['message'];
			}else{
				$message = $_SESSION['alert']['message'];

			}

			$message = appendString($message, $alerturl, 140);

		

	}

	


		if($user['type'] == "Email"){
					

			if(mail($user['email'],$_SESSION['alert']['subject'],$message, $headers, '-falert@iglou.com')){
							
				$ecount++;

			}else{


					$efcount++;
					$fcount++;

					//$failed[] = $user;

				}
			}elseif($user['type'] == "Text"){

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
