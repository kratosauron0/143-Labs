<html>
<body>

<?php
	# Open up MySQL Connection
	$connection = mysql_connect("localhost", "cs143", "");
	if(!$connection) {
		$errmsg = mysql_error($connection);
		print "Warning: DB Connection failure: $errmsg <br />";
	}
	else
		mysql_select_db("CS143", $connection);
?>

<h2>Search Film Database</h2>

<form action="./search.php" method="GET">		
	<b>Search:</b> <input type="text" name="keyword"></input>
	<input type="submit" value="Search"/>
</form>

<?php
	# Acquire and Sanitize User Input
	$keyword = mysql_real_escape_string($_GET[keyword], $connection);
	
	if($keyword)
	{
		echo "Now searching for <b><u>".$keyword."</u></b>...<br /><br />";
	}
	
	# Perform search on Actors
	$query = "SELECT first, last, dob, id FROM Actor WHERE ";
	
	$token1 = strtok($keyword, " ");
	$token2 = strtok(" ");
	if(!$token1)
	{
		# Quick Fix; easy way to kill the query
		$query .= "id = 999999999";
	}
	else if(!$token2)
	{
		$query .= "first LIKE '%".$token1."%' OR last LIKE '%".$token1."%'";
	}
	else
	{
		$k = 0;
		do{
			$query .= "(first LIKE '%".$token1."%' OR last LIKE '%".$token1."%') AND ";
			$token1 = $token2;
			$k += 1;
		}while($token2 = strtok(" "));
		$query .= "(first LIKE '%".$token1."%' OR last LIKE '%".$token1."%')";
	}
		
	$result = mysql_query($query, $connection);
	$row = mysql_fetch_row($result);
		
	# Print out actor info
	echo "<i>Searching for Actors</i> <br />";
	if(!$row)
	{
		echo "No results found<br />";
	}
	else
	{
		echo "<blockquote>";
		do{
			printf("<a href=\"./browseActor?aid=%d\">", $row[3]);
			echo $row[0]." ".$row[1]." (".$row[2].") </a><br />";
		}while($row = mysql_fetch_row($result));
		echo "</blockquote>";
	}
		
	# Perform search on Movies
	$query = "SELECT title, year, id FROM Movie WHERE ";
	if(!$keyword)
	{
		$query .= "id = 9999999999999";
	}
	else
	{
		$query .= "title LIKE '%".$keyword."%' ORDER BY title";
	}
	$result = mysql_query($query, $connection);
	$row = mysql_fetch_row($result);
	
	# Print out movie info
	echo "<i>Searching for movies</i>...<br />";
	if(!$row)
	{
		echo "No results found<br />";
	}
	else
	{
		echo "<blockquote>";
		do{
			printf("<a href=\"./browseMovie?mid=%d\">", $row[2]);
			echo $row[0]." (".$row[1].")</a><br />";
		}while($row = mysql_fetch_row($result));

		echo "</blockquote>";
	}
	
	#Close MySQL Connection
	mysql_close($connection);
?>

</body>
</html>