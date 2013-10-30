
<?php
include("../functions.php");
	dbconnect();

	$tbl_name="users";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM `$tbl_name`";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "admin.php?action=edit"; 	//your file name  (the name of this file)
	$limit = 5; 								//how many items to show per page
	$page = $_POST['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM `$tbl_name` ORDER BY `email` LIMIT $start, $limit ";
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
		$pagination .= "<div class=\"pagination\">";
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
	echo $pagination;
	?>
	<table class='table table-striped'>
		<th>Email Address</th>
		<th>Email / Phone</th>
		<th>Delete</th>
	<?php
		$count = ($limit * ($page-1))+1;
		while($row = mysql_fetch_array($result))
		{
	?>
	<tr>
		<td><? echo $row['email'] ?></td>
		<td><? echo $row['type'] ?></td>
		<td><button class='btn btn-sm btn-danger delete' id='<? echo $row['id'] ?>'>X</button></td>
	</tr>
	<?php
	$count++;
		}
	?>
	</table>

<?=$pagination?>

<script>
			var pgbtn = $(".pgbtn").hammer({

					hold_timeout: 0.000001

				});
			


			pgbtn.on("hold", function(ev){
				var page = $(this).attr("id");
				$("#page").attr("value", page)
				getPageData();
			});

			var deluser = $(".delete").hammer({

				hold_timeout:0.000001
			});

			deluser.on("hold", function(ev){
				var id = $(this).attr("id");
				posting = $.post("ajax/deluser.php", {id: id});
				posting.done(function(data){
					$("#userdelresult").html(data);
				});

			});



</script>
	