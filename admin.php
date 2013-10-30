<?php

session_start();
include("template/adminheader.php");

dbconnect();

//end header



$action = $_GET['a']; 

if($action == "logout"){ 

	$_SESSION['admin'] = false;

	session_destroy();  

	session_unset();	 

	session_unregister($SESSION['admin']);

}

if(!$_SESSION['admin']){

	include("template/adminlogin.php");

}else{



	if($action == "preview" && isset($_SESSION['alert']['subject']) && isset($_SESSION['alert']['message'])){

?>

		<div class="modal fade" id="confirm" style="display:none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Are you sure?</h4>
		      </div>
		      <div class="modal-body">
		        <p>Click Send to Submit Notification</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		        <button type="button" id="gogogo" class="btn btn-primary">Send Notification</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade" id="results" style="display:none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Results</h4>
		      </div>
		      <div class="modal-body" id="finalresults" >
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

<?



		dbconnect();
		$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='alerturl' AND `current`='yes'");
		$alerturl = mysql_fetch_assoc($query) or die(mysql_error());
		$alerturl = $alerturl['value'];
		$alerturl = preg_replace("[alert id]", $_SESSION['alert']['id'], $alerturl); 




		if($_SESSION['alert']['status'] == "down"){ 

			$label = "label-important";

		}elseif($_SESSION['alert']['status'] == "info"){

			$label = "label-warning";

		}else $label = "label-success";

		

		$squery = mysql_query("SELECT * FROM `services`") or die(mysql_error());

		$i = 0;
		$affected = array();

		while($serv = mysql_fetch_array($squery)){ //Compile all affect services into array

			if(in_array($serv['id'], $_SESSION['alert']['services'])){

				$affected[$i] = $serv;

				$i++;

			}

		}

		

		$_SESSION['users'] = getAffected($affected, $_SESSION['alert']['method']);

		$_SESSION['alert']['num'] = count($_SESSION['users']);

		

		

		

		$_SESSION['alert']['affected'] = $affected;







 //For display purposes only. Not sent to next page.	
 if(in_array("Text", $_SESSION['alert']['method'][0])){
			if($_SESSION['alert']['status'] == "down"){
					$txtmsg = "IgLou Outage Affecting:" . "\r\n";
					foreach($affected as $s){
					if($s['name'] != 'Announcements'){ 

						$txtmsg .= "".$s['name']."
";
					}

				}
			}elseif($_SESSION['alert']['status'] == "up"){
				$txtmsg = $_SESSION['alert']['subject'] . "\r\n" . $_SESSION['alert']['message'];
			}else{
				$txtmsg = $_SESSION['alert']['message'];

			}

			$txtmsg = appendString($txtmsg, $alerturl, 140);

		}

		if(in_array("Twitter", $_SESSION['alert']['method'][0])){
			if($_SESSION['alert']['status'] == "down"){
					$_SESSION['alert']['tweet'] = "IgLou Outage Affecting:" . "\r\n";
					foreach($affected as $s){
						if($s['name'] != 'Announcements'){ 

							$_SESSION['alert']['tweet'] .= "".$s['name']."
	";
						}

					}
			}elseif($_SESSION['alert']['status'] == "up"){
				$_SESSION['alert']['tweet'] = $_SESSION['alert']['subject'] . "\r\n" . $_SESSION['alert']['message'];
			}else{
				$_SESSION['alert']['tweet'] = $_SESSION['alert']['message'] . $alerturl;

			}

			$_SESSION['alert']['tweet'] = appendString($_SESSION['alert']['tweet'], $alerturl, 140);
			$tweet = $_SESSION['alert']['tweet'];
		}




		

		include("template/buildalertcontent.php");      //This file builds the content of the HTML email and saves 

														//it to a file for later utilization

?>

				<div class='row' style='max-width:500px; padding:0px; margin:0px;'>
					<ul class="nav nav-tabs" id="preTab" style="margin:0px;">
				<?php
					foreach($_SESSION['alert']['method'][0] as $method){
				?>

				
						<li >

							<a href="#<?echo $method ?>">

							<strong><? echo $method ?></strong>

							</a>

						</li>


					<?php

						}

					?>
						<li >

							<a href="admin.php">

							<strong>Edit</strong>

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

					

				

					<div class="well" style="padding:5px; margin-bottom:5px;">	 

						<div class="tab-content">

						<?php
							foreach($_SESSION['alert']['method'][0] as $method){
								if($method == "Email"){

							?>

						  <div class="tab-pane active" id="<?echo $method?>">

							<iframe seamless='seamless' style='max-width:510px; width:100%; height:400px;' src='alertcontents.html'></iframe>

						  </div>

						  	<?php

								}elseif($method == "Twitter"){

							?>

						  <div class="tab-pane " id="<?echo $method?>">

							<pre style='text-align:left; width:300px; background-color:white;'><? echo $tweet ?></font></pre>


						  </div>

						<?
							}else{
						?>

								<div class="tab-pane " id="<?echo $method?>">

							<pre style='text-align:left; width:300px; background-color:white;'><? echo $txtmsg ?></pre>


						  </div>
						 <?

						}
					}
						?>

						</div>



					

					</div>

					<br>

						<? echo "
						<form id='finalform'>
						<button type='submit' class='btn btn-primary btn-lg sendmail' href='admin.php?a=sendmail'>

						  Send Alert <span class='badge active' style='background-color:#FFFFFF; color:#3276b1;font-weight:bold; font-size:13pt;'> ".$_SESSION['alert']['num']." </span>

						</button>
						</form>
						<div id='finalerror'></div>
						";


						?>

				</div>

				<script>

			  $(function () {

				$('#preTab a:first').tab('show');

			  });

			  // Attach a submit handler to the form

			$( "#finalform" ).submit(function( event ) {

			  // Stop form from submitting normally

			  event.preventDefault();

			  // Get some values from elements on the page:

			  var $form = $( this );

			  // Send the data using post

			  var posting = $.post( "ajax/store_db.php", $form.serialize() );

			  // Put the results in a div

			  posting.done(function( data ) {

			 	 $("#finalerror").html(data);

			  });
			});

			$( "#gogogo" ).click(function( event ) {

				$("#confirm").modal('toggle');
				$("#results").modal('toggle');
				$('.sendmail').remove();
			  // Get some values from elements on the page:

			  var $form = $( this );

			  // Send the data using post

			  var posting = $.post( "ajax/sendmail.php", $form.serialize() );

			  // Put the results in a div

			  posting.done(function( data ) {

			 	 $("#finalresults").html(data);

			  });
			});
			$('#results').on('hide.bs.modal', function () {
				window.location="admin.php";
			})

			  </script>


		<?

		}else{

		//if(isset($_SESSION['alert'])) unset($_SESSION['alert']);

		?>

		

		<!--  Start Admin Main Menu  -->

		<div class='row' style='max-width:500px; padding:0px; margin:0px;'>

		

			<ul class="nav nav-tabs" id="myTab" >

				<li style='width:25%; text-align:left;'>

					<a href="#down"  class='<? if($_SESSION['alert']['status'] == "down" || !isset($_SESSION['alert']['status'])) echo "active"; ?> tabpadding'>

					<strong>Down</strong>

					</a>

				</li>

				<li style='width:25%;'>

					<a href="#up"  class='<? if($_SESSION['alert']['status'] == "up") echo "active"; ?> tabpadding'>

					<strong>Up</strong>

					</a>

				</li>

				<li style='width:30%;'>

					<a href="#info"  class='<? if($_SESSION['alert']['status'] == "info") echo "active"; ?> tabpadding'>

					<strong>Announce</strong>

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


			

		

		<div class="well" style="padding:5px;">	 

			<div class="tab-content">

			  <div class="tab-pane" id="down">

				<? echo getAdminUI('down'); ?>

			  </div>
			  <div class="tab-pane active" id="up">

				<? echo getAdminUI('up'); ?> 

			  </div>

			  <div class="tab-pane" id="info">

				<? echo getAdminUI('info'); ?> 

			  </div>

			</div>

			<div id='output'>

			</div>

			<div id='errormsg'></div>

		</div> 





			 

			<script>





			  $(function () {

				$('#myTab .active').tab('show');

			  })


			  // Attach a submit handler to the form

			$( ".adminform" ).submit(function( event ) {

			  // Stop form from submitting normally

			  event.preventDefault();

			  // Get some values from elements on the page:

			  var $form = $( this );

			  // Send the data using post

			  var posting = $.post( "ajax/store_var.php", $form.serialize() );

			  // Put the results in a div

			  posting.done(function( data ) {

			 	 $("#errormsg").html(data);

			  });
			});
 

    </script>

		<?

	 

	

	}

}



include("template/adminfooter.php")

?>