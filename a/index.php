<?php  


/**
*	This page accepts an ID by the GET (url) method, obtains the details of the alert stored the in `alerts` table of the database,
*	formats the alert just like the emails that are sent out, and displays it on the page. Super simple stuff.
**/

$i = $_GET['i']; //get the ID from the URL. 


include("../functions.php");

dbconnect();

$i = mysql_real_escape_string($i);  // Keep those filthy hackers at bay and sanitize the input

$i = trim($i); //Take out any whitespace, just in case they're still trying to hax you.

if($i && is_numeric($i)){       //Make sure that the ID is a number, and that one was entered.



	$query = mysql_query("SELECT * FROM `alerts` WHERE `id`= '$i'");  //Query the database for the id given

	$row = mysql_fetch_assoc($query) or die(mysql_error()); // Select the fields we need, or die if it doesn't exist. 

	$subject = $row['subject'];       //Storing results in variables. I copied the output code from a different file, so this made the 
									  //transition really easy.
	$message = $row['message'];

	$date = $row['date']; 

	$services = $row['services'];

	$status = $row['status'];

		// the services field is extracted as comma separated numbers, this command
		// turns it into an array of numbers as separated.
	$services = explode(",", $services); 



	if($status == "down"){   //This changes the color of the lables on the page according to the status of the alert.



			$label = "label-important";  //Red



		}elseif($status == "info"){



			$label = "label-warning";  //Orange



		}else $label = "label-success"; //Green (up)



		

			//The following bit of code collects all of the involved services from the database and 
			// stores them in an array for processing

		$squery = mysql_query("SELECT * FROM `services`") or die(mysql_error());

		$affected = array();

		while($serv = mysql_fetch_array($squery)){ //Compile all affect services into array

			if(in_array($serv['id'], $services)){

				$affected[] = $serv;

			}



		}



}else{	//If the ID entered isn't valid, save this error message to be displayed later.

	$errormsg = "<h2>The alert you are trying to view has either expired, or never existed.</h2><p> Here's a link to <a href='http://www.iglou.com/status/'>IgLou's Status Page</a></p>";

}





?>





		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>



		<html>



		<head>



		  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->



			<style>



				body {



				  margin: 0;



				  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;



				  font-size: 14px;



				  line-height: 20px;



				  color: #333333;



				  background-color: #5C5C5C;



				}



				.well {



				  min-height: 20px;



				  padding: 19px;



				  margin-bottom: 20px;



				  background-color: #f5f5f5;



				  border: 1px solid #e3e3e3;



				  -webkit-border-radius: 4px;



					 -moz-border-radius: 4px;



						  border-radius: 4px;



				  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);



					 -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);



						  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);



				}



				.form-signin {



					max-width: 300px;



					padding: 19px 29px 29px;



					margin: 0 auto 20px; 



					background-color: #fff;



					border: 1px solid #e5e5e5;



					-webkit-border-radius: 5px;



					   -moz-border-radius: 5px;



							border-radius: 5px;



					-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);



					   -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);



							box-shadow: 0 1px 2px rgba(0,0,0,.05);



				}



				.hero-unit {



				  padding: 60px;



				  margin-bottom: 30px;



				  font-size: 18px;



				  font-weight: 200;



				  line-height: 30px;



				  color: inherit;



				  background-color: #eeeeee;



				  -webkit-border-radius: 6px;



					 -moz-border-radius: 6px;



						  border-radius: 6px;



				}







				.hero-unit h1 {



				  margin-bottom: 0;



				  font-size: 60px;



				  line-height: 1;



				  letter-span*cing: -1px;



				  color: inherit;



				}



				label,



				input,



				button,



				select,



				textarea {



				  font-size: 14px;



				  font-weight: normal;



				  line-height: 20px;



				}



				label {



				  display: block;



				  margin-bottom: 5px;



				}



				.label,



				.badge {



				  display: inline-block;



				  padding: 2px 4px;



				  font-size: 11.844px;



				  font-weight: bold;



				  line-height: 14px;



				  color: #ffffff;



				  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);



				  white-span*ce: nowrap;



				  vertical-align: baseline;



				  background-color: #999999;



				}



				.label {



				  -webkit-border-radius: 3px;



					 -moz-border-radius: 3px;



						  border-radius: 3px;



				}



				a.label:hover,



				a.label:focus,



				a.badge:hover,



				a.badge:focus {



				  color: #ffffff;



				  text-decoration: none;



				  cursor: pointer;



				}



				.label-important,



				.badge-important {



				  background-color: #b94a48;



				}







				.label-important[href],



				.badge-important[href] {



				  background-color: #953b39;



				}







				.label-warning,



				.badge-warning {



				  background-color: #f89406;



				}







				.label-warning[href],



				.badge-warning[href] {



				  background-color: #c67605;



				}







				.label-success,



				.badge-success {



				  background-color: #468847;



				}







				.label-success[href],



				.badge-success[href] {



				  background-color: #356635;



				}







				.label-info,



				.badge-info {



				  background-color: #3a87ad;



				}

				ul{

					list-style-type: none;

					

				}







				.label-info[href],



				.badge-info[href] {



				  background-color: #2d6987;



				}







				.label-inverse,



				.badge-inverse {



				  background-color: #333333;



				}







				.label-inverse[href],



				.badge-inverse[href] {



				  background-color: #1a1a1a;



				}



			</style>



		</head>

 

		<body>



		<div class='well form-signin' style='max-width:500px; padding:1%;'>



		<div class='hero-unit' style='max-width:600px; text-align:left; padding:3%'>

		<?php 	
			//Validate that the subject exists and isn't a placeholder, if so continue.
			if($subject != 'placeholder' || $subject == ""){

				if($errormsg) {  //If there is an error, display it. If not, display the alert.

					echo $errormsg;

				}else{

		?>




			<!-- Display date -->
			<div style='text-align:right; float:right; '><font style='font-size:.65em'>Posted on <?php echo $date ?></font></div>


			<!-- Display subject -->
		<h2><?php  echo $subject ?></h2>



		





		<p>


			<!-- Display Message -->
		<?php  echo $message ?>



		</p>



		<center>





		<ul>



		<?php 







		$i=0;




		// The following loop displays all services that are affected by the alert in question.

		foreach($affected as $s){



			if($s['name'] != 'Announcements'){ 



			echo "<li><span class='label $label' style='width:145px; margin:0px;'>".$s['name']." </span>";



			$i++;

			}



			//if($i==2){ $i=0; $content .="";}



			



		}



	} 

}else{ //Fail if the subject doesn't exist or is a placeholder.

	echo "<h2>The alert you are trying to view has either expired, or never existed.</h2><p> Here's a link to <a href='http://www.iglou.com/status/'>IgLou's Status Page</a></p>";





}

?>





		</ul>



		</center>



		<p >



		<font style='font-size:10pt'>To modify your subscription to the IgLou Notification System, 





		<a href='http://hey.iglou.com'>click here</a>





		</font>



		</p>



		</div>



		</div>



		</body>



		</html>



		";



