$(document).ready(function(){

		// Initialize the hammer plugin.      

			
			var subscribe = $("#subscribe").hammer({

				hold_timeout: 0.000001

			});


			subscribe.on("hold", function(ev){
				$('#subform').submit();
			});

			var msgcheck = $(".msgcheck").hammer({

				hold_timeout: 0.000001

			});


			msgcheck.on("hold", function(ev){
				
				id = $(this).attr("id");
				boxid = $(this).find("input").attr("id");
				console.log(boxid);
				selectX(id, boxid);
			});
			

		

			var clear = $("#clear").hammer({

				hold_timeout: 0.000001

			});

			

			

			clear.on("hold", function(ev){

				document.getElementById('val').value = "";

				document.getElementById('calc').innerHTML = "";

			});

			

			

			var submit = $("#calcsubmit").hammer({

				hold_timeout: 0.000001

			});

			

			submit.on("hold", function(ev){

				$("#calcform").submit();

				

			});

			

			var hammertime = $(".button").hammer({

				hold_timeout: 0.000001

			});



			// add multiple event listeners on the selector.

			hammertime.on("hold", function(ev) {

				login = document.getElementById('val');

				calc = document.getElementById('calc');

				login.value += $(this).attr('id');

				calc.innerHTML += $(this).attr('id');

			});

			

			var checkoption = $(".overbox").hammer({

				hold_timeout: 0.000001

			});

			

			checkoption.on("hold click tap", function(ev) {
				ev.preventDefault();
				selectX($(this).attr('id'), 'x'+$(this).attr('id'));

			});

			

			var checkall = $(".allbox").hammer({

				hold_timeout: 0.000001

			});

			

			checkall.on("hold", function(ev) {

				checkBox($(this).attr('id'), $(this).attr('name'));

			});	

			

			var switchscreen = $(".ibutton").hammer({

				hold_timeout: 0.000001

			});

			

			switchscreen.on("hold", function(ev) {

					if($(this).attr('value') == '^'){

						showup();

					}else if($(this).attr('value') == '?'){

						showinfo();

					}else{

						showdown();

					}

					

			});

			

			

			$("#upselect").change(function() {

				var id = $(this).children(":selected").attr("id");

				if(id == "Custom Message"){

					toggleSubject('up');

				}else{

					document.getElementById('uptext').innerText = id;

				}	

			});

			

			$("#downselect").change(function() {

				var id = $(this).children(":selected").attr("id");

				if(id == "Custom Message"){

					toggleSubject('down');

				}else{

					document.getElementById('downtext').innerText = id;

				}

			});


			

			var tab = $("#myTab a").hammer({

				hold_timeout: 0.000001

			});
			

			tab.on("hold", function(e) {

				e.preventDefault();

				$(this).tab('show');

			});



			var pretab = $("#preTab a").hammer({
 
				hold_timeout: 0.000001

			});

			

			pretab.on("hold", function(e) {

				e.preventDefault();

				$(this).tab('show');

			});
 
			

			

			var sendmail = $(".sendmail").hammer({

				hold_timeout: 0.000001
 
			});

			

			sendmail.on("hold", function(e) {

				$("#sendmail").submit();

			});

			

			var subject = $(".subject").hammer({

				hold_timeout: 0.000001

			});

			

			subject.on("hold", function(e) {

				var status = $(this).attr('value');

				toggleSubject(status);


				$("#"+status+"select").trigger("select");

			});

			

			var ltxt = $("#ltxt").hammer({

				hold_timeout: 0.000001

			});

			

			ltxt.on("hold", function(e) {

				$("#l_provider").show();

				$("#l_type").html("<i class='glyphicon glyphicon-phone pull-left'></i>Text");

				$("#l_t").attr("value", "Text");

				$("#txtalert").show();

				$('.phone').attr('required','required');

				$('#l_p').attr('required','required');

				$('.email').removeAttr('required');

				$(".email").hide();

				$(".phone").show();

				$(".error:not(.email, .phone, #l_p)").remove();

			});

			

			var lemail = $("#lemail").hammer({

				hold_timeout: 0.000001

			});

			

			lemail.on("hold", function(e) {

				$("#l_provider").hide();

				$("#l_type").html("<i class='glyphicon glyphicon-envelope pull-left'></i>Email");

				$("#l_t").attr("value", "Email");

				$("#txtalert").hide();

				$('.phone').removeAttr('required');

				$('#l_p').removeAttr('required','required');

				$('.email').attr('required','required');

				$(".phone").hide();

				$(".email").show();

				$(".error:not(.email, .phone, #l_p)").remove();

			});

			

			var lprovider = $(".lprovider").hammer({

				hold_timeout: 0.000001

			});

			

			lprovider.on("hold", function(e) {

				var id = $(this).attr("id");

				$("#l_provtxt").html(id);

				$("#l_p").attr("value", id);

				

			});

			

			var lother = $(".lother").hammer({

				hold_timeout: 0.000001

			});

			

			lother.on("hold", function(e) {

				$("#otheralert").show();

			});

			

		});

		

		

		

		function checkBox(div, type){

			div = document.getElementById(div);

			y = document.getElementById(type);

			y.checked = !y.checked;

			if(y.checked) { 

				$(div).addClass('btn-warning');
				$(div).removeClass('btn-default');

			} else {
				$(div).removeClass('btn-warning');
				$(div).addClass('btn-default');
			}

			checkboxes = document.getElementsByName(type+'[]');

			for(var i=0, n=checkboxes.length;i<n;i++) {

				//checkboxes[i].checked = y.checked;

				selectX(type+i,checkboxes[i].id, y)

			}
 
		}

		function selectX(divid, xboxid, y){

			box = document.getElementById(xboxid);

			div = document.getElementById(divid);

			box.checked = !box.checked;

			if(y){ box.checked = y.checked; }

			if(box.checked) { 

				$(div).addClass('btn-warning');
				$(div).removeClass('btn-default');

			} else {
				$(div).removeClass('btn-warning');
				$(div).addClass('btn-default');
			}

		}

		function toggleSubject(status){

			$("#"+status+"select").toggle();
			$("#"+status+"subject").toggle();

		

		}

		