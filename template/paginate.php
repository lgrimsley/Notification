
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
	$limit = 15; 								//how many items to show per page
	$page = $_GET['pagenum'];
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
			$pagination.= "<a href=\"$targetpage&pagenum=$prev\">< previous</a>";
		else
			$pagination.= "<span class=\"disabled\">< previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&pagenum=$counter\">$counter</a>";					
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
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagenum=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&pagenum=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&pagenum=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage&pagenum=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&pagenum=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagenum=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&pagenum=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&pagenum=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage&pagenum=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&pagenum=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagenum=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&pagenum=$next\">next ></a>";
		else
			$pagination.= "<span class=\"disabled\">next ></span>";
		$pagination.= "</div>\n";		
	}
	echo $pagination;
	?>
	<table width="800">
		<td width="350"><b>Listing Name (Click To Edit)</b></td>
		<td><b>Address</b></td>
		<td><b>Delete Listing</b></td>
		<tr>
	<?php
		$count = ($limit * ($page-1))+1;
		while($row = mysql_fetch_array($result))
		{
		if($row['listing_address_number']) $aptnum = "&nbsp(#" . $row['listing_address_number'] . ")";
			else $aptnum = "";
	?>
		<td width="350">
			<? echo $count . " | <a href='editlistingform.php?listingid=" . $row['listing_id'] . "'>" .  $row['listing_label'] . "</a> <td valign='center' width='300'><center> " . $row['listing_address_street'] . $aptnum . "</td>  <td valign='right' width='125' id='div" . $row['listing_id'] . "'><center><b> <a href='admin.php?action=delete&listingid=" . $row['listing_id'] . "' id='". $row['listing_id'] . "' style='display:none; color:#FFFFFF' class='delete' >Are you sure?</a></b> <a class='delete' onClick='performDelete(this, " . $row['listing_id'] . ")' >(X)DELETE</a></center>";	?>			
		</td>
		<tr>
	<?php
	$count++; 
		}
	?>
	</table>


<?=$pagination

echo "<script>
	var pgbtn = $('.pgbtn').hammer({

					hold_timeout: 0.000001

				});
			


			pgbtn.on('hold', function(ev){
				var page = $(this).attr('id');
			 	console.log('asdasd');
				$('#page').attr('value', page)
				getPageData();
			});
	</script>";
?>


	