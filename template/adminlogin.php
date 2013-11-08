



	<div class="row col-md-12" id='calcformstyle' style='box-shadow: 2px 2px 5px #000000; '>



		<form  id='calcform' >

			<div class='buttonholder'>
				<div  class='btn btn-lg btn-primary col-md-4 ' style="min-width:83px !important;min-height:83px !important;padding: 10% 2% 2% 2% !important; " id="clear">



					<span class="vmiddle lbtntxt " style='font-weight:bold; '>C</span>



				</div> 

 

				<div  class='btn btn-lg btn-default col-md-8' disabled style="min-width:170px !important;min-height:83px !important;padding:0px !important;padding-bottom:2% !important; " >



					<div class="vmiddle lbtntxt" style="text-align:right; font-size:2em; text-align:right;" id="calc"></div>



				</div>
			</div>

			<div class='buttonholder'>
				<div  class='btn btn-lg btn-primary button col-md-4' id="1">



					<span class="vmiddle lbtntxt ">1</span>



				</div>



				<div  class='btn btn-lg btn-primary button col-md-4' id="2">



					<span class="vmiddle lbtntxt ">2</span>



				</div>



				<div  class='btn btn-lg btn-primary button col-md-4' id="3">



					<span class="vmiddle lbtntxt ">3</span>



				</div> 
			</div>


	





			<div class='buttonholder'>
				<div  class='btn btn-lg btn-primary button col-md-4' id="4">



					<span class="vmiddle lbtntxt">4</span>



				</div> 



				<div  class='btn btn-lg btn-primary button col-md-4' id="5">



					<span class="vmiddle lbtntxt">5</span>



				</div>



				<div  class='btn btn-lg btn-primary button col-md-4' id="6">



					<span class="vmiddle lbtntxt">6</span>



				</div>
			</div>


		






			<div class='buttonholder'>
				<div  class='btn btn-lg btn-primary button col-md-4' id="7">



					<span class="vmiddle lbtntxt"> 7</span>



				</div>



				<div  class='btn btn-lg btn-primary button col-md-4' id="8">



					<span class="vmiddle lbtntxt"> 8</span>



				</div>



				<div  class='btn btn-lg btn-primary button col-md-4' id="9">



					<span class="vmiddle lbtntxt"> 9</span>



				</div> 

			</div>


	



	 


			<div class='buttonholder'>
				<div  class='btn btn-lg btn-primary  button col-md-8' id="0"  style=' text-align:right; width:64% !important; min-width:170px !important; padding: 10% 13% 2% 2% !important;'>



					<span class="vmiddle lbtntxt " style="text-align:right;  display:table-cell;">0</span>
 


				</div>



				<div  class='btn btn-lg btn-primary col-md-4 ' style="min-width:83px !important;min-height:83px !important;padding: 10% 2% 2% 2% !important;"  id="calcsubmit"  >



					<center><span class="vmiddle lbtntxt" >=</span>



				</div>

			</div>





			



				<input type='hidden' id='val' name='val'>







			



		</form>

		<div id='errormsg'></div>



		<script>

			$( "#calcform" ).submit(function( event ) {

				  // Stop form from submitting normally

				  event.preventDefault();

				 

				  // Get some values from elements on the page:

				  var $form = $( this );

				 

				  // Send the data using post

				  var posting = $.post( "ajax/auth.php", $form.serialize() );

				 

				  // Put the results in a div

				  posting.done(function( data ) {

				 	

				 	 $("#errormsg").html(data);



				  });





				});

   		</script>



	</div>