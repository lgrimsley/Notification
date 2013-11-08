
		
		<button type='button' id='notyou' class='label label-warning btn btn-warning' style='box-shadow: 1px 1px 1px #5C5C5C;text-shadow: 2px 2px 3px #5C5C5C; font-size:1em;  font-weight:125; float:left; position:absolute; min-width:100px; z-index:10;  margin-top:0px; margin-left:0px;  ' >			
			<? echo $email;?>				
			<br>				
			<small>Not you? Click here</small>

		</button>	





	<form action='index.php?a=add' id='subform' method='POST'>

		<div class='row ' style='padding-top:0%; padding-left:0;'>					
			<div class='col-md-1 '></div>					
			<div class='col-md-11 '><center>						
				<div class='page-header' style='width:70%;text-align:center;'>
				 	<h1 style='text-align:left; padding-top:3%; margin-left:-30px;'>
				 		Manage Your Subscriptions							
				 		<p >
				 			<small >
				 				Choose services, then click Subscribe.
				 				<br>
				 				Subscribed services are highlighted in 
				 				<font color='orange' style='font-weight:bold'>orange</font>
				 			</small>																		 						
				 		</p>						
				 	</h1>												
				 </div> 											
				</div> 				
			</div>							
			<div class='row col-md-12'>					
				<center>																				
					<div class='row' style='max-width:420px'>						
						<? echo showSubscription($email, ""); ?>												
						<br>					
						<input type='hidden' value='<? echo $email ?>' name='Email'>				
						<div class='row'>					
							<a href='index.php?a=unsubscribe&Email=<? echo $email ?>'>						
								<div class='btn btn-lg btn-danger btntxt text-center' style="height: 3em; font-weight:bold; width: 35%; margin:3%;">							
									<span class='vmiddle'>Unsubscribe <i class="glyphicon glyphicon-ban-circle"></i>							
									</span>						
								</div>					
							</a>  												
							<div class='btn btn-lg btn-primary btntxt text-center' id='subscribe' style="font-weight:bold;height: 3em;  width: 35%; margin:3%;">													
								<span class='vmiddle'>Subscribe <i class="glyphicon glyphicon-ok"></i></span>						
							</div>									
						</div>
					</div>			
				</div>
		</form>