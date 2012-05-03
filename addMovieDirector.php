<html>
<head> <title>Add Director to Movie</title> </head>
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

<b>Add New Director to a Movie:</b><br/>
<form method="GET">
Movie: <select name="mid">
<?php
	if($connection) {
		$query_movies = "SELECT id, title FROM Movie
					ORDER BY title";
		
		# Get the list of all movies and ids from the db
		$result_movies = mysql_query($query_movies, $connection);
		if($result_movies) {
			while($row = mysql_fetch_row($result_movies)) {
				printf( "<option value=\"%s\">%s</option>",
					$row[0], $row[1]);
			}
		}
?>
</select><br/>
Director: <select name="did">
<?php
		$query_directors = "SELECT id, first, last FROM Director
					ORDER BY first, last";
		
		
		$result_directors = mysql_query($query_directors, $connection);
		if($result_directors) {
			while($row = mysql_fetch_row($result_directors)) {
				printf( "<option value =\"%s\">%s %s</option>",
					$row[0], $row[1], $row[2]);
			}
		}
	}
?>
</select><br/>
<input type="submit" value="Add">
</form>

<?php
	if($connection && $_GET["mid"] && $_GET["did"]) {
		$insert_moviedirector = sprintf("INSERT INTO MovieDirector
						Values(%d, %d)",
						mysql_real_escape_string($_GET["mid"]), 
						mysql_real_escape_string($_GET["did"]));
		
		
		print "<hr/>\n";
		$results_insert = mysql_query($insert_moviedirector);
		if($results_insert)
			print "Add Success!";
		else
			printf("%s failed", $insert_moviedirector);
	}
	
	mysql_close($connection);
?>
</body>
</html>