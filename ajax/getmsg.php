<?php

session_start();

include("../functions.php");

dbconnect();

if(isset($_SESSION['admin'])){


	$tbl_name="default";		//your table name

	// How many adjacent pages should be shown on each side?

	$adjacents = 3;

	$status = $_POST['status'];


	/* 

	   First get total number of rows in data table. 

	   If you have a WHERE clause in your query, make sure you mirror it here.

	*/
	   if($status == "all"){

	   	$query = "SELECT COUNT(*) as num FROM `$tbl_name`";

	   }else{
	   	$query = "SELECT COUNT(*) as num FROM `$tbl_name` WHERE `status`='$status'";
	   }
	

	$total_pages = mysql_fetch_array(mysql_query($query));

	$total_pages = $total_pages[num];

	

	/* Setup vars for query. */


	$limit = 4; 								//how many items to show per page

	$page = $_POST['mpageid'];


	if($page) 

		$start = ($page - 1) * $limit; 			//first item to display on this page

	else

		$start = 0;								//if no page var is given, set start to 0

	

	/* Get data. */

	if($status == "all"){

	   	$sql = "SELECT * FROM `$tbl_name`  ORDER BY `title` LIMIT $start, $limit ";

	   }else{

		$sql = "SELECT * FROM `$tbl_name` WHERE `status`='$status'  ORDER BY `title` LIMIT $start, $limit ";
	}

	$result = mysql_query($sql);

	

	/* Setup page vars for display. */

	if ($page == 0) $page = 1;					//if no page var is given, default to 1.

	$prev = $page - 1;							//previous page is page - 1

	$next = $page + 1;							//next page is page + 1

	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.

	$lpm1 = $lastpage - 1;						//last page minus 1

	

	/* 

		Now we apply our rules and draw the pagination object. 

		We're actually saving the code to a variable in case we want to draw it more than once.

	*/

	$pagination = "";

	if($lastpage > 1)

	{	

		$pagination .= "<div style='margin:3px;'>";

		//previous button

		if ($page > 1) 

			$pagination.= "<button type='button' id='$prev' class='btn btn-sm btn-info pgbtn'>< Previous</button>";

		else

			$pagination.= "<button type='button' class='disabled btn btn-sm btn-info pgbtn'>< Previous</button>";	

		

		//pages	

		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up

		{	

			for ($counter = 1; $counter <= $lastpage; $counter++)

			{

				if ($counter == $page)

					$pagination.= "<button type='button' id='$counter' class='disabled btn btn-sm btn-info pgbtn'>$counter</button>";

				else

					$pagination.= "<button type='button' id='$counter' class='btn btn-sm btn-info pgbtn'>$counter</button>";					

			}

		}

		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some

		{

			//close to beginning; only hide later pages

			if($page < 1 + ($adjacents * 2))		

			{

				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if ($counter == $page)

						$pagination.= "<button type='button' id='$counter' class=' disabled btn btn-sm btn-info pgbtn'>$counter</button>";

					else

						$pagination.= "<button type='button' id='$counter' class='btn btn-sm btn-info pgbtn'>$counter</button>";					

				}

				$pagination.= "...";

				$pagination.= "<button type='button' id='$lpm1' class='btn btn-sm btn-info pgbtn'>$lpm1</button>";

				$pagination.= "<button type='button' id='$lastpage' class='btn btn-sm btn-info pgbtn'>$lastpage</button>";		

			}

			//in middle; hide some front and some back

			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= "<button type='button' id='1' class='btn btn-sm btn-info pgbtn'>1</button>";

				$pagination.= "<button type='button' id='2' class='btn btn-sm btn-info pgbtn'>2</button>";

				$pagination.= "...";

				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if ($counter == $page)

						$pagination.= "<button type='button' id='$counter' class=' disabled btn btn-sm btn-info pgbtn'>$counter</button>";

					else

						$pagination.= "<button type='button' id='$counter' class='btn btn-sm btn-info pgbtn'>$counter</button>";					

				}

				$pagination.= "...";

				$pagination.= "<button type='button' id='$lpm1' class='btn btn-sm btn-info pgbtn'>$lpm1</button>";

				$pagination.= "<button type='button' id='$lastpage' class='btn btn-sm btn-info pgbtn'>$lastpage</button>";		

			}

			//close to end; only hide early pages

			else

			{

				$pagination.= "<button type='button' id='1' class='btn btn-sm btn-info pgbtn'>1</button>";

				$pagination.= "<button type='button' id='2' class='btn btn-sm btn-info pgbtn'>2</button>";

				$pagination.= "...";

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)

				{

					if ($counter == $page)

						$pagination.= "<button type='button' id='$counter' class=' disabled btn btn-sm btn-info pgbtn'>$counter</button>";

					else

						$pagination.= "<button type='button' id='$counter' class='btn btn-sm btn-info pgbtn'>$counter</button>";					

				}

			}

		}

		

		//next button

		if ($page < $counter - 1) 

			$pagination.= "<button type='button' id='$next' class='btn btn-sm btn-info pgbtn'>next ></button>";

		else

			$pagination.= "<button type='button' class='btn btn-sm btn-info pgbtn disabled'>next ></span>";

		$pagination.= "</div>\n";		

	}

	echo "<center>" . $pagination . "</center>";

	?>
	<table class='table table-striped table-condensed'>
	<tr>
		<td>
			<table>
				<tr>
					<th style='width:30%'>Title</th>

					<th style='width:60%'>Full Text</th>

					<th style='width:10%'>Edit/Delete</th>
				</tr>
			</table>
		</td?
	</tr>

	<?php

		$count = ($limit * ($page-1))+1;

		while($row = mysql_fetch_array($result))

		{

	?>

	<tr> 
		<td>
			<form id='m<? echo $row['id'] ?>'>
				<table>
					<tr>
						<td style='width:30%'>
							<textarea name='title' rows='4' cols='6' style='display:none;margin:0px;' class='form-control form<? echo $row['id'] ?>'><? echo $row['title'] ?></textarea>
							<pre style='margin:0px;' class='display<? echo $row['id'] ?>'><? echo $row['title'] ?></pre>
						</td>

						<td style='width:60%'><textarea name='text' cols='6' rows='4' style='display:none;margin:0px;' class='form-control form<? echo $row['id'] ?>'><? echo $row['text'] ?></textarea>
							<pre style='margin:0px;' class='display<? echo $row['id'] ?>'><? echo $row['text'] ?></pre>
						</td>

						<td style='width:5%'>
							<button type='button' class='btn btn-sm btn-success submitedit form<? echo $row['id'] ?>' name='<? echo $row['id'] ?>' style='display:none;'><i class='glyphicon glyphicon-floppy-disk'></i></button>
							<button type='button' class='btn btn-sm btn-success edit display<? echo $row['id'] ?>' name='<? echo $row['id'] ?>'><i class='glyphicon glyphicon-pencil'></i></button>
							<br>
							<button type='button' class='btn btn-sm btn-info canceledit form<? echo $row['id'] ?>' name='<? echo $row['id'] ?>' style='display:none;'><i class='glyphicon glyphicon-floppy-remove'></i></button>
							<button type='button' class='btn btn-sm btn-danger delete display<? echo $row['id'] ?>' name='<? echo $row['id'] ?>'><i class='glyphicon glyphicon-remove'></i></button>
							<button type='button' class='btn btn-sm btn-danger delconfirm' id='delconfirm<? echo $row['id'] ?>' name='<? echo $row['id'] ?>' style='display:none;'><i class='glyphicon glyphicon-trash'></i></button>
							<input type='hidden' name='id' value='<? echo $row['id'] ?>'>
							
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>

	<?php

	$count++;

		}

	?>

	</table>


<center>
<?=$pagination?>
</center>


<script>

			$("#msgerror").html("");

			var pgbtn = $(".pgbtn").hammer({

					hold_timeout: 0.000001

				});

			pgbtn.on("hold", function(ev){

				var page = $(this).attr("id");

				$("#msgpageid").attr("value", page)

				getMsg();

			});


			var delmsg = $(".delete").hammer({

				hold_timeout:0.000001

			});



			delmsg.on("hold", function(ev){

				var id = $(this).attr("name");
				$(this).hide();
				$("#delconfirm"+id).show(); 

			});

			var delconfirm = $(".delconfirm").hammer({

				hold_timeout:0.000001

			});

			delconfirm.on("hold", function(ev){

				    
					var id = $(this).attr("name");


					posting = $.post("ajax/delmsg.php", {id: id});
				
					posting.done(function(data){
						var currpage = $("#mpageid").attr("value");
						if(currpage > 1){
							$("#mpageid").attr("value", currpage-1);
						}
						getMsg();
					});
				

				

			});

			var edit = $(".edit").hammer({

				hold_timeout:0.000001
			});

			edit.on("hold", function(ev){
				var id = $(this).attr("name");
				$(".form"+id).show();
				$(".display"+id).hide();

			});

			var canceledit = $(".canceledit").hammer({

				hold_timeout:0.000001
			});

			canceledit.on("hold", function(ev){
				var id = $(this).attr("name");
				$(".form"+id).hide();
				$(".display"+id).show();

			});



			var submitedit = $(".submitedit").hammer({

				hold_timeout:0.000001

			});


			submitedit.on("hold", function(ev){

				var id = $(this).attr("name");
				console.log("#m"+id);
				var $subform = $("#m"+id);


				posting = $.post("ajax/editmsg.php", $subform.serialize());

				posting.done(function(data){

					$("#msgerror").html(data);

				});



			});







</script>
<?
}
?>
	