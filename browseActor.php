<html>
<head> <title>Browse Actors</title> </head>
<body>
<?php
	$connection = mysql_connect("localhost", "cs143", "");
	if(!$connection) {
		$errmsg = mysql_error($connection);
		print "Warning: DB Connection failure: $errmsg <br />";
	}
	else
		mysql_select_db("CS143", $connection);
?>

<h2>Browse Actors</h2>
<b>Choose Actor:</b><br/>
<form method="GET">
<select name="aid">
<?php
	if($connection) {
		$query = "SELECT id, first, last FROM Actor
					ORDER BY first, last";
		
		
		$result = mysql_query($query, $connection);
		if($result) {
			while($row = mysql_fetch_row($result)) {
				if($row[1] == "" && $row[2] == "")
					$row[1] = $row[0];
					
				if($_GET["aid"] && $_GET["aid"] == $row[0])
					printf( "<option value =\"%s\" SELECTED>%s %s</option>\n",
						$row[0], $row[1], $row[2]);
				else
					printf( "<option value =\"%s\">%s %s</option>\n",
						$row[0], $row[1], $row[2]);
			}
		}
	}
?>
</select>
<input type="submit" value="Go">
</form>

<?php
	if($connection && $_GET["aid"])
	{
		$query_actor = sprintf("SELECT * from Actor WHERE id = %d",
			$_GET["aid"]);
		$query_movies = sprintf("SELECT role, mid, title, year
								FROM Movie, MovieActor
								WHERE id = mid AND aid = %d",
			$_GET["aid"]);
			
		$result_actor = mysql_query($query_actor, $connection);
		$result_movies = mysql_query($query_movies, $connection);
		
		if($result_actor) {
			$row = mysql_fetch_row($result_actor);
			for($col=0; $col < count($row); $col++) {
				if($row[$col] == "" && $col == 5)
					$row[$col] = "N/A";
				else if($row[$col] == "")
					$row[$col] = "Unknown";
			}
			printf("Name: %s %s<br/>\nSex: %s<br/>\nDate of Birth: %s<br/>
				Date of Death: %s<br/>",
				$row[2], $row[1], $row[3], $row[4], $row[5]);
		}
		
		print "<br/>";
		print "Movies Acted In:<br/>";
		if($result_movies) {
			while($row = mysql_fetch_row($result_movies)) {
				printf("Played %s in <a href=\"./browseMovie?mid=%d\">%s(%s)</a><br/>\n", 
				$row[0], $row[1], $row[2], $row[3]);
			}
		}
	}

	mysql_close($connection);
?>
</body>
</html>