<center><div class="container">		
<script src="js/jquery.maskedinput.min.js"></script>	
	<div class="form-signin" style='max-width:420px; padding-left:0%; padding-right:0%;'>      
	<form  id="emailform"  class="padding: 19px 29px 29px;" method="GET" action="index.php?a=services&">	  
	<h2>		IgLou Internet Services<br>        
	<small>			Notification System		</small>	 
	</h1>		
	<input type="hidden" name="a" value="services">		
	<input type="hidden" style='display:none' id='l_p' name="l_p">	
	<input type="hidden" id='l_t' name="l_t" value="Email">			
	<table class="input-group row"  >  
		<td>
			<span class="btn-group ">   
				<button class="btn btn-default dropdown-toggle" style='width:90px'  data-toggle="dropdown">  
					<span id='l_type'><i class="glyphicon glyphicon-envelope pull-left"></i> Email</span> 
					<span class="caret"></span>   
				</button>  
				<ul class="dropdown-menu" role="menu" style='min-width:100px;'>	
					<li ><a href='#' id='lemail'><i class="glyphicon glyphicon-envelope pull-left"></i>Email</a></li>

					<li ><a href='#' id='ltxt'><i class="glyphicon glyphicon-phone pull-left"></i>Text</a></li>   
				</ul>   
			</span> 
		</td>
		<td>
			<input type="email" name="Email" id="PrependedDropdownButton" style='width:230px; height:33px; margin-top:0px;!important' required="required" class=" form-control email pull-center" placeholder="Email"> 
			<input type="tel" name="phoneUS" id="phoneUS" style='width:100%; display:none; height:33px; margin-top:0px; !important' class=" form-control phone pull-center" placeholder="Phone Number">    
	  	</td>
	  	<td>
	  		<span class="btn-group" > 
				<button class="btn btn-default dropdown-toggle" id='l_provider' style='width:90px; display:none;'  data-toggle="dropdown">     
				<span id='l_provtxt'>Provider</span>      
				<span class="caret"></span>    
				</button>    
				<ul class="dropdown-menu" role="menu2" style='min-width:90px;'>

					<?php	dbconnect();	
					$query = mysql_query("SELECT * FROM `providers`") or die(mysql_error());	

					while($providers = mysql_fetch_array($query)){			
					echo "<li><a href='#' class='lprovider' id='".$providers['name']."'>".$providers['name']."</a><li>";		
					}?>	
				<li><a href='#' class='lother' id='other'>Other</a></li>  

				</ul>  
			

			</span>  
		</td>
	</table>    

	<br>

	<button class="btn btn-lg btn-primary" style="" type="submit" > Next <i class="glyphicon glyphicon-arrow-right"></i></button></form>	


	<span id='invalid'></span> <!-- This thing to the left here is where error messages go. Please don't touch.-->		 	


	<div class="alert alert-danger" style=' margin-top:5%; margin-bottom:0%; display:none;' id="otheralert">		 
	<button type="button" class="close" data-dismiss="alert">&times;</button>		  
	<h4>Is your mobile provider not listed?</h4> 	

	<a href='mailto:vip@iglou.com'>Send us an email</a> and let us know. 		</div>		

	<div class="alert alert-info" style='display:none; margin-top:5%; ' id='txtalert'>		

	<h4>Attention!</h4>			Message and data rates may apply.		</div>		

	<noscript>	

	<div class="alert alert-danger" style=' margin-top:5%; margin-bottom:0%; display:none;' id="otheralert">		

	<button type="button" class="close" data-dismiss="alert">&times;</button>			  

	<h4>Javascript Required</h4> 	
	Javascript is required to view this website. You appear to have it disabled, please enable it to continue. 		
	</div>		</noscript>		</div>     		

		<script>			
		$("#phoneUS").mask("(999) 999-9999");	
		$('#emailform').validate({			
			ignore: "",			
			messages: {				

				l_p: "Select a provider.<br>",			
				PrependedDropdownButton: "Enter an email address.<br>",		
				phoneUS: "Enter a 10 digit phone number<br>",		
			},		
			errorLabelContainer: '#invalid',	
		});		
		</script>  
	</div>