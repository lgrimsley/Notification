<?php
session_start();
include("template/adminheader.php");



if(!$_SESSION['admin']){
 echo "<script> window.location='admin.php' </script>";
}else{


dbconnect();
$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='alerturl' AND `current`='yes'");
$alerturl = mysql_fetch_assoc($query) or die(mysql_error());

$alerturl = $alerturl['value']; 

?>


<!--  Start Admin Main Menu  -->

		<div class='row' style='max-width:500px; padding:0px; margin:0px;'>

		

			<ul class="nav nav-tabs" id="myTab" >

				<li style='width:25%; text-align:left;'>

					<a href="#general" >

					<strong>General</strong>

					</a>

				</li>

				<li style='width:25%;'>

					<a href="#messages">

					<strong>Messages</strong>

					</a>

				</li>

				<li style='width:30%;'>

					<a href="#subs">

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


			

		

		<div class="well" style="padding:5px;">	 

			<div class="tab-content" style='text-align:left;'>

			  <div class="tab-pane active" id="general">
			  	
			  	<div class="panel panel-info btn-info">
			  		<a href='#pwchange' data-toggle='modal'>
					  <div class="panel-body settingspanel row">
					    <span class='col-md-4'>
					    	Change Password
			  			</span>
			  			<span id='pwresult' class='col-md-8' style='text-align:right'></span>
					  </div>
					</a>
				</div>
				<div class="panel panel-info btn-info">
					<a href='#subscribers' data-toggle='modal'>
					  <div class="panel-body settingspanel row">
					    <span class='col-md-6'>
					    	Delete Subscribers
			  			</span>
			  			<span id='subresult' class='col-md-8' style='text-align:right'></span>
					  </div>
					</a>
				</div>
				<div class="panel panel-info btn-info">
					<a href='#url' data-toggle='modal'>
					  <div class="panel-body settingspanel row">
					    <span class='col-md-4'>
					    	Change Alert Link-Back
			  			</span>
			  			<span id='alerturlresult' class='col-md-8' style='text-align:right'></span>
					  </div>
					</a>
				</div>

			  </div>
			  <div class="tab-pane" id="messages">




				
			  </div>

			  <div class="tab-pane" id="subs">


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
		      		<div class='col-md-4'>
		      			Text:
		      		</div>
		      		<div class='col-md-4'>
		      			URL:
		      		</div>
		      		<div class='col-md-4'>
		      			Alert ID:
		      		</div> 
		      	</div>
		      	<div class='row input-group'>
		      		<form id='urlchange'>
			      		<div class='col-md-5 input-group' style='padding:0px;'>
			      			<input type='text' id='text' name='text' placeholder="Ex: View full alert here: " class='form-control'>
			      			<span class='input-group-addon'></span>
			      			
			      		</div>
			      		<div class='col-md-4' style='padding:0px;'>
			      			<input type='text' id='url' placeholder='Ex: www.myalert.com' name='url' class='form-control'>
			      		</div>
			      		<div class='col-md-3' style='padding:0px;'>
			      			<input type='text' id='alertid' name='alertid' disabled class='disabled form-control' value='?i=[alert url]'>
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





			 

	<script>

 

			$(function () {

				$('#myTab a:first').tab('show');

			  });
			  
			$('#subscribers').on('show.bs.modal', function () {

				getPageData();

			})

			function getPageData(){

				var posting = $.ajax({
					type: "POST",
					url: "ajax/getsubscribers.php", 
					data: $("#page").serialize(),

				});

				posting.done(function(data){
					$("#subbody").html(data);
				});

				var pgbtn = $(".pgbtn").hammer({

					hold_timeout: 0.000001

				});

			}
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




			

			  
	</script>

<?
}
?>