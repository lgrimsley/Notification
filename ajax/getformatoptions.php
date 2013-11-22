<?php  

session_start();


if(isset($_SESSION['admin'])){
	include("../functions.php");

	dbconnect();

	$type = $_POST['type'];
	$status = $_POST['status'];


	if($_POST['format']){
		$format = $_POST['format'];
	}else{
		$query = mysql_query("SELECT `value` FROM `settings` WHERE `type`='".$status.$type."format' AND `current`='yes'");
		if(mysql_num_rows($query)){
			$format = mysql_result($query, 0);
		} else{
			$format = "";
		}
		$format = explode(",",$format);
	}

		if(in_array("title", $format)) $titlestatus = "active";
		if(in_array("subject", $format)) $subjectstatus = "active";
		if(in_array("message", $format)) $messagestatus = "active";
		if(in_array("footer", $format)) $footerstatus = "active";
		if(in_array("services", $format)) $servicesstatus = "active";
		if(in_array("linkback", $format)) $linkbackstatus = "active";

	?>

<center>
	<form id="changeformat">
		<div class="btn-group pull-center" data-toggle="buttons"  >
		  <label class="btn btn-info <?php echo $titlestatus ?>" id='title' style='width:150px'>
		    <input type="checkbox"  class=' changeformat ' id='changetitle' <?php  if($titlestatus == "active") echo "checked='checked'"; ?> name='format[]' value='title'>
		     Custom Header
		  </label>
		  <label class="btn btn-info <?php echo $subjectstatus ?>" id='subject' style='width:150px'>
		    <input type="checkbox" class=' changeformat' <?php  if($subjectstatus == "active") echo "checked='checked'"; ?> name='format[]' value='subject'>
		     Subject
		  </label>
		  <label class="btn btn-info <?php echo $messagestatus ?>" id='message'  style='width:150px'>
		    <input type="checkbox" class='changeformat' <?php  if($messagestatus == "active") echo "checked='checked'"; ?> name='format[]' value='message'>
		     Message
		  </label>
		</div>
		<div class="btn-group pull-center" data-toggle="buttons">
		  <label class="btn btn-info <?php echo $footerstatus ?>" id='footer'  style='width:150px'>
		    <input type="checkbox"  class='changeformat ' id='changefooter' <?php  if($footerstatus == "active") echo "checked='checked'"; ?> name='format[]' value='footer'>
		     Custom Footer
		  </label>	
		  <label class="btn btn-info <?php echo $servicesstatus ?>" id='services'  style='width:150px'>
		    <input type="checkbox" class=' changeformat' <?php  if($servicesstatus == "active") echo "checked='checked'"; ?> name='format[]' value='services'>
		     Services
		  </label>
		  <label class="btn btn-info <?php echo $linkbackstatus ?>" id='linkback'  style='width:150px'>
		    <input type="checkbox" class=' changeformat' <?php  if($linkbackstatus == "active") echo "checked='checked'"; ?> name='format[]' value='linkback'>
		     Link-Back
		  </label>
		</div>

		<input type='hidden' name='status' value='<?php echo $status?>'>
		<input type='hidden' name='type' value='<?php echo $type?>'>
	</form>
</center>


	
		<script>



		flipCustom();
		getCustom();

			function getMessageFormat(){

				$("#msgpreview").html("");
				var $form = $("#changeformat");
				var posting = $.post("ajax/getformat.php", $form.serialize());

				posting.done(function(data){
					$("#msgpreview").html(data);

				});
			}

			getMessageFormat();


			$(".changeformat").change(function(ev){
				getMessageFormat();

			});

			$("#changetitle").change(function(ev){

				flipCustom();

			});
			$("#changefooter").change(function(ev){

				flipCustom();

			});

			function flipCustom(){

				var custom = $("#customdiv");
				var preview = $("#previewdiv");

				if($("#changetitle").prop("checked") || $("#changefooter").prop("checked") ) { 

					custom.show();
					getCustom();
					preview.removeClass('col-md-12');
					preview.addClass('col-md-6')

					if($("#changetitle").prop("checked")){
						$(".title").show();
					}else{
						$(".title").hide();
					}

					if($("#changefooter").prop("checked")){
						$(".footer").show();
					}else{
						$(".footer").hide();
					}

				} else {
					custom.hide();
					preview.removeClass('col-md-6');
					preview.addClass('col-md-12')
				}
			}

			

		</script>

	<?php 
}else{
	echo "Your session has expired. You must login again to access this page <a href='admin.php'>(Click Here)</a>";
}


?>