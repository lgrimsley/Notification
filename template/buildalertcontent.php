<?php



$content .=  "

		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>

		<html>

		<head>

		  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

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

		<h2>".$_SESSION['alert']['subject']."</h2>



		";

		

		$content .= "

		<p>

		".$_SESSION['alert']['message']."

		</p>

		<center>

		<!--START--!>
		<ul>
		";

		$i=0;

		foreach($affected as $s){

			if($s['name'] != 'Announcements'){ 

			$content .= "<li><span class='label $label' style='width:145px; margin:0px;'>".$s['name']." </span>";

			$i++;
			}

			//if($i==2){ $i=0; $content .="";}

			

		}

		

		$content .=  "
		</ul>
		<!--END--!>

		</center>

		<p >

		<font style='font-size:10pt'>To modify or unsubscribe from IgLou Alert System, 
		<!--SURL--> 

		<a href='http://lgrimsley.com/alert/index.php'>click here</a>

		<!--EURL-->

		</font>

		</p>

		</div>

		</div>

		</body>

		</html>

		";

		

		file_put_contents("alertcontents.html", $content);

?>