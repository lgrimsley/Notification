

<!DOCTYPE html>

<html lang="en">

	<head>

		<title>IgLou Early Warning System</title>

		<link rel="icon" href="favicon.ico">

		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="bootstrap_full/dist/css/bootstrap-theme.min.css">
   		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>	

		<script src="js/jquery.validate.min.js"></script>

		<script src="js/hammer.js"></script>

		<script src="js/jquery.hammer.js"></script>

		<script src="js/common.js"></script>

		<style type="text/css">

			  body {

				text-align:center;

				padding-top: 2px;

				padding-bottom: 0px;

				padding-left:3px;

				padding-right:3px;

				margin:2px;

				background-color: #f5f5f5;
				background-image: url("img/tweed.png");
				background-repeat: repeat;

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

			  .form-signin .form-signin-heading,

			  .form-signin .checkbox {

				margin-bottom: 10px;

			  }

			  .form-signin input[type="text"],

			  .form-signin input[type="password"] {

				font-size: 16px;

				height: auto;

				margin-bottom: 15px;

				padding: 7px 9px;

			  }



			</style>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->

	</head>

	<body>

	<center>

		<?php
		include("functions.php");

		ini_set('session.bug_compat_warn', 0);

		ini_set('session.bug_compat_42', 0);

		?> 