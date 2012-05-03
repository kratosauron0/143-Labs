<html>
<head> <title>Add Actor to Movie</title> </head>
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

<b>Add New Actor to a Movie:</b><br/>
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
				printf( "<option value=\"%s\">%s</option>\n",
					$row[0], $row[1]);
			}
		}
?>
</select><br/>
Actor: <select name="aid">
<?php
		$query_actors = "SELECT id, first, last FROM Actor
					ORDER BY first, last";
		
		
		$result_actors = mysql_query($query_actors, $connection);
		if($result_actors) {
			while($row = mysql_fetch_row($result_actors)) {
				printf( "<option value =\"%s\">%s %s</option>\n",
					$row[0], $row[1], $row[2]);
			}
		}
	}
?>
</select><br/>
Role: <input type="text" name="role" maxlength="50"><br/>
<input type="submit" value="Add">
</form>

<?php
	if($connection && $_GET["mid"] && $_GET["aid"] && $_GET["role"]) {
		$insert_movieactor = sprintf("INSERT INTO MovieActor
						Values(%d, %d, %s)",
						mysql_real_escape_string($_GET["mid"]), 
						mysql_real_escape_string($_GET["did"]),
						mysql_real_escape_string($_GET["role"]));
		
		
		print "<hr/>\n";
		$results_insert = mysql_query($insert_moviedirector);
		if($results_insert)
			print "Add Success!<br/>\n";
		else
			printf("%s failed", $insert_moviedirector);
	}
	
	mysql_close($connection);
?>
</body>
</html>