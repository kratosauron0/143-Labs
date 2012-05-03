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
	$query = "SELECT first, last FROM Actor";
	$result = mysql_query($query, $connection);
	$row = mysql_fetch_row($result);
		
	# Print out actor info
	echo "<i>Support for searching for actors not implemented</i> <br />";
	
	echo "<br />";
	
	# Perform search on Movies
	$query = "SELECT title, year, id FROM Movie WHERE title LIKE '%".$keyword."%'";
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