<?php

session_start();

include("template/adminheader.php");







if(!$_SESSION['admin']){

 echo "<script> window.location='admin.php' </script>";

}else{



dbconnect();

$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='alerturl' AND `current`='yes'");

$alerturl = mysql_fetch_assoc($query);



$alerturl = $alerturl['value']; 



?>





<!--  Start Admin Main Menu  -->



		<div class='row' style='max-width:500px; padding:0px; margin:0px;'>



		



			<ul class="nav nav-tabs" id="myTab" style='border-bottom:0px !important;'>



				<li style='width:25%; text-align:left;'>



					<a href="#general" class='tabpadding'>



					<strong>General</strong>



					</a>



				</li>



				<li style='width:25%;'>



					<a href="#messages" class='tabpadding' onclick="getMsg()">



					<strong>Messages</strong>



					</a> 



				</li>



				<li style='width:30%;'>



					<a href="#subs" class='tabpadding' onclick="getSubs()">



					<strong>Subscriptions</strong>



					</a>



				</li>



				<li style=' width:18%; ' class='dropdown' >



					<a  href="#" class='tabpadding dropdown-toggle' data-toggle='dropdown'>



					<strong><i class='glyphicon glyphicon-wrench'></i> <span class="caret"></span></strong>



					</a>



					<ul class="dropdown-menu pull-right">

   						<li>

   							<a href='admin.php'>Notification System</a>

   						</li>

   						<li>

   							<a href='index.php'>User Subscription</a>

   						</li>

   						<li>

   							<a href='settings.php'>Settings</a>

   						</li>

   						<li class='divider'></li>

   						<li>

   							<a href='admin.php?a=logout'>Logout</a>

   						</li>

   					</ul>



				</li>



			</ul>





			



		



		<div class="well" style="padding:5px; box-shadow: 2px 2px 5px #000000; min-height:467px;">	 



			<div class="tab-content" style='text-align:left;'>



			  <div class="tab-pane active" id="general">

			  	

			  	<div class="panel panel-info btn-info">

			  		<a href='#pwchange' data-toggle='modal'>

					  <div class="panel-body settingspanel row">

					    <span class='col-md-4'>

					    	Change Password

			  			</span>

			  			<span id='pwresult' class='col-md-8' style='text-align:right; font-size:.8em;'></span>

					  </div>

					</a>

				</div>

				<div class="panel panel-info btn-info">

					<a href='#subscribers' data-toggle='modal'>

					  <div class="panel-body settingspanel row">

					    <span class='col-md-6'>

					    	View / Delete Subscribers

			  			</span>

			  			<span id='subresult' class='col-md-8' style='text-align:right; font-size:.8em;'></span>

					  </div>

					</a>

				</div>

				<div class="panel panel-info btn-info">

					<a href='#url' data-toggle='modal'>

					  <div class="panel-body settingspanel row">

					    <span class='col-md-5'>

					    	Change Alert Link-Back

			  			</span>

			  			<span id='alerturlresult' class='col-md-7' style='text-align:right; font-size:.8em;'></span>

					  </div>

					</a>

				</div>

				<div class="panel panel-info btn-info">

					<a href='#twitter' data-toggle='modal'>

					  <div class="panel-body settingspanel row">

					    <span class='col-md-5'>

					    	Edit Twitter Codes

			  			</span>

			  			<span id='twitresult' class='col-md-7' style='text-align:right; font-size:.8em;'></span>

					  </div>

					</a>

				</div>

				<div class="panel panel-info btn-info">

					<a href='#msgformat' data-toggle='modal'>

					  <div class="panel-body settingspanel row">

					    <span class='col-md-12'>

					    	Customize Text / Twitter Formattng

			  			</span>

					  </div>

					</a>

				</div>

				<div class="panel panel-info btn-info">

					<a href='#charlimit' data-toggle='modal'>

					  <div class="panel-body settingspanel row">

					    <span class='col-md-8'>

					    	Text / Twitter Char Limit

			  			</span>

			  			<span id='charlimitresult' class='col-md-4' style='text-align:right; font-size:.8em;'></span>

					  </div>

					</a>

				</div>



			  </div>

			  <div class="tab-pane" id="messages">
			  	<div class='row'>
			  		<div class='col-md-8'>
					  	<form id='mpageid'>
					  			<input type='hidden' id='msgpageid' name='mpageid' value='1'>
						  		<select name='status' style='width:100%; font-weight:bold;' class='btn btn-info pull-left'  onChange="getMsg()">
						  			<option selected value='all'>All</option>
						  			<option value='down'>Down</option>
						  			<option value='up'>Up</option>
						  		</select>
						</form>
					</div>
					<div class='col-md-4'>
						<a href='#newmsgmodal' data-toggle="modal">
							<button type='button' class='btn btn-warning pull-right' style='width:100%;' id='newmsg'>New Message</button>
						</a>
					</div>
				</div>
						  	
				  	<div id='msgbody'></div>
				  	<div id='msgerror'></div>
			   </div>
			  	
			  		
			  	 

			  <div class="tab-pane" id="subs">  
			  	<div class='row'>
			  		<center>
						<a href='#newsubmodal' data-toggle="modal">
							<button type='button' class='btn btn-warning' style='width:50%;' id='newsub'>New Subscription Type</button>
						</a>
					</center>
				</div>
				
				
				  	<div id='subsbody'></div>
				  	<div id='subserror'></div>

				  	<form id='spageid'>
					  	<input type='hidden' id='spage' name='spage' value='1'>
					</form>
				


			  </div>



			</div>



		</div> 





		<div class="modal fade" id="pwchange">

		  <div class="modal-dialog">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		        <h4 class="modal-title">Change Password</h4>

		      </div>

		      <div class="modal-body">

		      	<p>

		        	<form id='pwchangeform' style='text-align:left;'>

			  		<div class='row '>

			  			<div class='col-md-2'></div>

			  			<div class='col-md-4 vmiddle'>

			  				Old Password:

			  			</div>

			  			<div class='col-md-5'>

			  				<input type='password' name='pwold' class='form-control'>

			  			</div>

			  		</div>

			  		<div class='row '>

			  			<div class='col-md-2'></div>

			  			<div class='col-md-4'>

			  				New Password:

			  			</div>

			  			<div class='col-md-5'>

			  				<input type='password' name='pw1' class='form-control'>

			  			</div>

			  		</div>

			  		<div class='row '>

			  			<div class='col-md-2'></div>

			  			<div class='col-md-4'>

			  				Re-enter New Password:

			  			</div>

			  			<div class='col-md-5'>

			  				<input type='password' name='pw2' class='form-control'>

			  			</div>

			  		</div>

			  		<div class='row'>

			  			<div class='col-md-12 error' style='text-align:center;' id='pwerror'></div>

			  		</div>

		        </p>

		      </div>

		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

		        <button type="button" class="btn btn-primary gogogo">Change Password</button>

		        </form>

		      </div>

		      <div id='pwerror'></div>

		    </div><!-- /.modal-content -->

		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->





		<div class="modal fade" id="subscribers">

		  <div class="modal-dialog">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		        <h4 class="modal-title">Delete Subscribers</h4>

		      </div>

		      <div style='margin-top:1px; margin-bottom:1px;'>

		      	<p id='subbody'>

		        	

		        </p>

		        <div id='userdelresult'></div>

		        <form id='pageid'><input type='hidden' id='page' name='page' value='1'></form>

		      </div>

		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

		      </div>

		      <div id='pwerror'></div>

		    </div><!-- /.modal-content -->

		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->



		<div class="modal fade" id="url">

		  <div class="modal-dialog">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		        <h4 class="modal-title">Change "View Alert" Link-Back</h4>

		      </div>

		      <div class="modal-body">

		      	<div class='row'>

		      		<div class='col-md-12'>

		      			Current Alert Link-Back:

		      		</div>

		      	</div>

		      	<div class='row'>

		      		<div class='col-md-12'>

		      			<pre><? echo $alerturl ?></pre>

		      		</div>

		      	</div>

		      	<hr>

		      	<div class='row'>

		      		<div class='col-md-3'>

		      			Text:

		      		</div>

		      		<div class='col-md-6'>

		      			URL:

		      		</div>

		      		<div class='col-md-3'>

		      			Alert ID:

		      		</div> 

		      	</div>

		      	<div class='row input-group col-md-12' style='padding:0px'>

		      		<form id='urlchange'>

			      		<div class='col-md-5 input-group' style='padding:0px;'>

			      			<input type='text' id='text' name='text' placeholder="Ex: View full alert here: " class='form-control'>

			      			<span class='input-group-addon'></span>

			      			

			      		</div>

			      		<div class='col-md-7 input-group' style='padding:0px;'>

			      			<input type='text' id='url' placeholder='Ex: www.myalert.com' name='url' class='form-control'>

			      			<span class='input-group-addon'>?i=[alert id]</span>

			      		</div>

		      		</form>

		      	</div>

		        <div id='alerturlerror'></div>

		      </div>

		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

		        <button type="button" class="btn btn-primary gochangeurl">Apply Changes</button>

		      </div>

		      <div id='pwerror'></div>

		    </div><!-- /.modal-content -->

		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->



		<div class="modal fade" id="twitter">

		  <div class="modal-dialog">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		        <h4 class="modal-title">Edit Twitter Codes</h4>

		      </div>

		      <div class="modal-body">

		      	<center>

		      		<a href='https://dev.twitter.com/apps' target="_blank"><div class='panel panel-header panel-info  btn-info'>Get Codes Here</div></a>



		      <form id='twitterform'>

		      	<table class='table table-striped table-condensed' style='font-size:.8em;'>

		      		<tr >

		      			<th style='width:20%;'>

		      			</th>

		      			<th style='width:40%;'>

		      				Current Keys:

		      			</th>

		      			<th style='width:40%;'>

		      				New Keys:

		      			</th>

		      		</tr>

		      		<tr >

		      			<td style='vertical-align:middle;'>			      

			      			Consumer Key:

			      		</td>

			      		<td>

			      			<pre id='consumerKey'></pre>

			      		</td>

			      		<td>

			      			<textarea type='text' rows='2' name='consumerKey' class='form-control'></textarea>

			      		</td>

			      	</tr>

			      	<tr>

		      			<td style='vertical-align:middle;'>			      

			      			Consumer Secret:

			      		</td>

			      		<td>

			      			<pre id='consumerSecret'></pre>

			      		</td>

			      		<td>

			      			<textarea type='text' rows='2' name='consumerSecret' class='form-control'></textarea>

			      		</td>

			      	</tr>

			      	<tr>

		      			<td style='vertical-align:middle;'>			      

			      			Access Token:

			      		</td>

			      		<td>

			      			<pre id='accessToken'></pre>

			      		</td>

			      		<td>

			      			<textarea type='text' rows='2' name='accessToken' class='form-control'></textarea>

			      		</td>

			      	</tr>

			      	<tr>

		      			<td style='vertical-align:middle;'>			      

			      			Access Token Secret:

			      		</td>

			      		<td>

			      			<pre id='accessTokenSecret'></pre>

			      		</td>

			      		<td>

			      			<textarea type='text' rows='2' name='accessTokenSecret' class='form-control'></textarea>

			      			<input type='hidden' name='getkeys' value='0'>

			      		</td>

			      	</tr>

			      </table>

			  </form>



				<div id='twittererror'></div>	       

		      </div>



		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

		        <button type="button" class="btn btn-primary gochangetwitter">Test and Save Codes</button>

		      </div>

		    </div><!-- /.modal-content -->

		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->


		<div class="modal fade" id="msgformat">

		  <div class="modal-dialog">

		    <div class="modal-content">

		    	

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        
			      <h4 class="modal-title">Edit Message Format</h4><br>

			       <div> 

			        <form id='formattype'>
			        	<select class='form-control pull-center ' onChange="getFormatOptions();" style='width:50%; display:inline-block; margin:5px;' name='status'>
			        		<option value='down'>Down</option>
			        		<option value='up'>Up</option>
			        		<option value='info'>Announcements</option>
			        	</select>

			        	<div class="btn-group pull-center" data-toggle="buttons">
						  <label class="btn btn-success active">
						    <input type="radio"  onChange="setType('Text'); getFormatOptions();"  value='Text'> Text
						  </label>
						  <label class="btn btn-success ">
						    <input type="radio"  onChange="setType('Twitter'); getFormatOptions();" value='Twitter'> Twitter
						  </label>
						</div>
						<input type='hidden' id='type' name='type' value='Text'>
					</form>

				</div>
		       

		       

		        

		      </div>

		      <div style='margin-top:1px; margin-bottom:1px;'>
		      	 <div class='row' id='formatoptions'></div>
		      	<p id='formatbody'>

					<div class='row'>
						<div class='col-md-6' id='customdiv' style='text-align:left; display:none; height:100%; min-height:250px; border-right: 1px solid lightgray;'>


							<div class='col-md-12 title' style='display:none;'>
								Custom Header:
							</div>
							<form id='titleform'>
							<div class='col-md-12 title input-group' style='display:none;'>
								
						      <input type='text' id="inputtitle" class='form-control' required='required' name='customtitle' maxlength='50'>
						      <span class='input-group-btn'>
						        <button class='btn btn-default titlebtn' type='button'><i class='glyphicon glyphicon-chevron-right'></i></button>
						      </span>
						  	</div>
						  	</form>
						  	<form id='footerform'>
						  	<div class='col-md-12 footer' style='display:none;'>
								Custom Footer:
							</div>
							<div class='col-md-12 footer input-group'>
						      <input type='text' id="inputfooter" required='required' class='form-control' name='customfooter' maxlength='50'>
						      <span class='input-group-btn'>
						        <button class='btn btn-default footerbtn' type='button'><i class='glyphicon glyphicon-chevron-right'></i></button>
						      </span>
						  	</div>


							</form>


						</div>


						<div class='col-md-12' id='previewdiv'>
							<center>
								Preview:
							<pre id='msgpreview' style='width:100%; max-width:250px; min-height: 250px; text-align:left;'></pre>
							<center>

						</div>

					</div>

		        </p>
		        <center><b>Changes are saved automatically.</b></center>
		      </div>

		      <div class="modal-footer">

		      	<div id='formaterror'></div>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

		      </div>
		    </div><!-- /.modal-content -->


		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->



<div class="modal fade" id="newmsgmodal">

		  <div class="modal-dialog">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		        <h4 class="modal-title">Add Messages</h4>

		      </div>

		      <div class="modal-body">

		      	<p>

		        	<form id='newmsgform' style='text-align:left;'>

			  		<div class='row '>


			  			<div class='col-md-5 vmiddle'>

			  				Select Message Type: 

			  			</div>

			  			<div class='col-md-6'>

			  				<select name='status' style='width:100%;' class='btn btn-info'>
			  					<option value='down'>Down</option>
			  					<option value='up'>Up</option>
			  				</select>

			  			</div>

			  		</div>

			  		<div class='row '>



			  			<div class='col-md-5 vmiddle'>

			  				Title/Subject:

			  			</div>

			  			<div class='col-md-6'>

			  				<input type='text' name='title' class='form-control'>

			  			</div>

			  		</div>

			  		<div class='row '>


			  			<div class='col-md-5 vmiddle'>

			  				Message Text:

			  			</div>

			  			<div class='col-md-6'>

			  				<textarea class='form-control' name='text' style='min-width: 250px;' rows='6'></textarea>

			  			</div>

			  		</div>

			  		<div class='row'>

			  			<div class='col-md-12 error' style='text-align:center;' id='newerror'></div>

			  		</div>

		        </p>

		      </div>

		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

		        <button type="button" class="btn btn-primary gonewmsg">Add Message</button>

		        </form>

		      </div>


		    </div><!-- /.modal-content -->

		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->

		<div class="modal fade" id="newsubmodal">

		  <div class="modal-dialog">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		        <h4 class="modal-title">Add Subscription Type</h4>

		      </div>

		      <div class="modal-body">

		      	<p>

		        	<form id='newsubform' style='text-align:left;'>


			  		<div class='row '>



			  			<div class='col-md-5 vmiddle'>

			  				Subscription Name:

			  			</div>

			  			<div class='col-md-6'>

			  				<input type='text' name='service' class='form-control' maxlength='25'>

			  			</div>

			  		</div>


			  		<div class='row'>

			  			<div class='col-md-12 error' style='text-align:center;' id='newsuberror'></div>

			  		</div>

		        </p>

		      </div>

		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

		        <button type="button" class="btn btn-primary gonewsub">Add Subscription</button>

		        </form>

		      </div>


		    </div><!-- /.modal-content -->

		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->

		<div class="modal fade" id="charlimit">

		  <div class="modal-dialog">

		    <div class="modal-content">

		      <div class="modal-header">

		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

		        <h4 class="modal-title">Change Character Limits</h4>

		      </div>

		      <div class="modal-body">

		      	<p>

		        	<form id='charlimitform' style='text-align:left;'>


			  		<div class='row '>



			  			<div class='col-md-4 col-md-offset-2 vmiddle'>

			  				Text Character Limit: 

			  			</div>

			  			<div class='col-md-3'>

			  				<input type='text' name='textlimit' id='textlimit' class='form-control' style='width:50px' maxlength='3'>

			  			</div>

			  		</div>
			  		<div class='row '>



			  			<div class='col-md-4 col-md-offset-2 vmiddle'>

			  				Twitter Character Limit: 

			  			</div>

			  			<div class='col-md-3'>

			  				<input type='text' name='twitterlimit' id='twitterlimit' class='form-control' style='width:50px' maxlength='3'>

			  			</div>

			  		</div>


			  		<div class='row'>

			  			<div class='col-md-12 error' style='text-align:center;' id='charlimiterror'></div>

			  		</div>

		        </p>

		      </div>

		      <div class="modal-footer">

		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

		        <button type="button" class="btn btn-primary gocharlimit">Save Changes</button>

		        </form>

		      </div>


		    </div><!-- /.modal-content -->

		  </div><!-- /.modal-dialog -->

		</div><!-- /.modal -->













			 



	<script>


			$(function () {



				$('#myTab a:first').tab('show');



			  });

			  

			$('#subscribers').on('show.bs.modal', function () {



				getPageData();



			})



			$('#twitter').on('show.bs.modal', function () {



				getTwitterData();



			})

			$('#msgformat').on('show.bs.modal', function () {

				clearData();
				getFormatOptions();

			});

			$('#charlimit').on('show.bs.modal', function () {

				clearData();
				getCharLimit();

			});


			$('#msgformat').on('hide.bs.modal', function () {

				clearData();

			})

			function clearData(){
				$("#twittererror").html("");
				$("#subbody").html("");
				$("#msgbody").html("");
				$("#subsbody").html("");
				$("#msgpreview").html("");
			}

			function getCharLimit(){

				var posting = $.post("ajax/getcharlimit.php", {getcharlimit: true});
				posting.done(function(data){
					$("#charlimiterror").html(data);
				});
			}



			function getTwitterData(){



				var posting = $.ajax({

					type: "POST",

					url: "ajax/changetwitter.php", 

					data: {getkeys: true},

 

				});



				posting.done(function(data){

					$("#twittererror").html(data);

				});



				var pgbtn = $(".pgbtn").hammer({



					hold_timeout: 0.000001



				});



			}



			function getPageData(){

				var posting = $.ajax({

					type: "POST",

					url: "ajax/getsubscribers.php", 

					data: $("#page").serialize(),

				});

				posting.done(function(data){

					clearData();

					$("#subbody").html(data);

				});

				var pgbtn = $(".pgbtn").hammer({

					hold_timeout: 0.000001

				});

			}

			function setType(type){


				$('#type').attr('value',type);

			}


			function getFormatOptions(){

				getCustom();

				var posting = $.ajax({

					type: "POST",

					url: "ajax/getformatoptions.php", 

					data: $("#formattype").serialize(),

				});

				posting.done(function(data){

					$("#formatoptions").html(data);

				});

			}


			function getMsg(){

				var posting = $.ajax({

					type: "POST",

					url: "ajax/getmsg.php", 

					data: $("#mpageid").serialize(),

				});



				posting.done(function(data){

					clearData();

					$("#msgbody").html(data);

				});

				var pgbtn = $(".pgbtn").hammer({

					hold_timeout: 0.000001

				});

			}

			function getSubs(){

				var posting = $.ajax({

					type: "POST",

					url: "ajax/getsubs.php", 

					data: $("#spageid").serialize(),

				});



				posting.done(function(data){

					clearData();

					$("#subsbody").html(data);

				});

				var pgbtn = $(".pgbtn").hammer({

					hold_timeout: 0.000001

				});

			}

				function clearNewMsg(){
					$("#newmsgform").find("input[type=text], textarea").val("");
				}


				$(".gochangetwitter").click(function(event){



					var $form = $("#twitterform");



					var posting = $.ajax({

						type: "POST",

						url: "ajax/changetwitter.php", 

						data: $form.serialize(),

						});



					posting.done(function(data){



			 		if(data == "Success "){

			 			$("#twitter").modal("toggle");

			 			$("#twitresult").html("Successfully Changed Codes");



			 		}else{

			 			$("#twittererror").html(data);

			 		}



					});



				});



				$(".gochangeurl").click(function(event){



					var $form = $("#urlchange");



					var posting = $.post("ajax/changeurl.php", $form.serialize() );



					posting.done(function(data){ 



						if(data == "Success "){

			 			$("#url").modal('toggle');



			 			var getnewurl = $.post("ajax/changeurl.php", {view: true} );

			 			getnewurl.done(function(data){

			 				$("#alerturlresult").html(data);

			 			});



			 			

			 		}else{

			 			$("#alerturlerror").html(data);

			 		}



					});



				});



				$( ".gogogo" ).click(function( event ) {

 

			 	// Get some values from elements on the page:



			 	var $form = $( "#pwchangeform" );



			 	// Send the data using post



			 	var posting = $.post( "ajax/changepw.php", $form.serialize() );



			 	// Put the results in a div



			 	posting.done(function( data ) {

			 		if(data == "Success "){

			 			$("#pwchange").modal('toggle');

			 			$("#pwresult").html(" [ Password changed! ]");

			 		}else{

			 			$("#pwerror").html(data);

			 		}

			 		



			    });
			 });
			

				$( ".gonewmsg" ).click(function( event ) {


			 	var $form = $( "#newmsgform" );

			 	var posting = $.post( "ajax/newmsg.php", $form.serialize() );

			 	posting.done(function( data ) {

			 			$("#newerror").html(data);

			    });

			});

				$( ".gocharlimit" ).click(function( event ) {


			 	var $form = $( "#charlimitform" );

			 	var posting = $.post( "ajax/getcharlimit.php", $form.serialize() );

			 	posting.done(function( data ) {

			 			$("#charlimit").modal("toggle");
			 			clearData();
			 			$("#charlimitresult").html(data);

			    });

			});

			$( ".gonewsub" ).click(function( event ) {


			 	var $form = $( "#newsubform" );

			 	var posting = $.post( "ajax/newsubs.php", $form.serialize() );

			 	posting.done(function( data ) {

			 			
			 			
			 			$("#newsuberror").html(data);


			    });
			});

			$(".titlebtn").click(function(ev){
				var $form = $("#titleform, #formattype"); 
				var posting = $.post("ajax/getformat.php", $form.serialize());
				posting.done(function(data){
					$("#msgpreview").html(data);
				});
			});

			$(".footerbtn").click(function(ev){
				var $form = $("#footerform, #formattype"); 
				var posting = $.post("ajax/getformat.php", $form.serialize());
				posting.done(function(data){
					$("#msgpreview").html(data);
				});
			});

			function getCustom(){
				var $form = $("#formattype");

				var posting = $.post("ajax/getcustom.php", $form.serialize());
				posting.done(function(data){
					$("#formaterror").html(data);

				});
			}
			








			



			  

	</script>



<?

}

?>