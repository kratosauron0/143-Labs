<html>
<body>
<?php
	# Setup the database connection
	$connection = mysql_connect("localhost", "cs143", "");
	if(!$connection) {
		$errmsg = mysql_error($connection);
		print "Warning: DB Connection failure: $errmsg <br />";
	}
	else
		mysql_select_db("CS143", $connection);
?>

<b>Choose Movie:</b><br/>
<form method="GET">
<select name="mid">
<?php
	if($connection) {
		$query = "SELECT id, title FROM Movie
					ORDER BY title";
		
		# Get the list of all movies and ids from the db
		$result = mysql_query($query, $connection);
		if($result) {
			while($row = mysql_fetch_row($result)) {
				# If no name, then use movie id
				if($row[1] == "")
					$row[1] = $row[0];
				# If the user already selected one, is viewing that info
				# then it will be the selected one on the menu
				if($_GET["mid"] && $_GET["mid"] == $row[0])
					printf( "<option value=\"%s\" SELECTED>%s</option>",
						$row[0], $row[1]);
				# Otherwise it's not the one the user chose
				else
					printf( "<option value=\"%s\">%s</option>",
						$row[0], $row[1]);
			}
		}
	}
?>
</select><br/>
<input type="submit" value="Go">
</form>

<?php
	if($connection && $_GET["mid"]){
		$query = sprintf("SELECT * FROM Movie WHERE id = %d", 
			$_GET["mid"]);
		$query_director = sprintf("SELECT first, last FROM Director, MovieDirector
						WHERE id = did AND mid = %d",
			$_GET["mid"]);
		$query_genre = sprintf("SELECT genre FROM MovieGenre where mid = %d",
			$_GET["mid"]);
		$query_actors = sprintf("SELECT id, first, last, role
								FROM Actor, MovieActor
								WHERE id = aid AND mid = %d",
			$_GET["mid"]);
					
		$result = mysql_query($query, $connection);
		$result_director = mysql_query($query_director, $connection);
		$result_genre = mysql_query($query_genre, $connection);
		$result_actors = mysql_query($query_actors, $connection);
		
		if($result) {
			$row = mysql_fetch_row($result);
			for($col=0; $col < mysql_num_fields($result); $col++) {
				$field = mysql_fetch_field($result, $col);
				if ($field) 
				{
					if($row[$col] != "")
						printf("%s: ".$row[$col]."<br/>", $field->name);	
					else
						printf("%s: "."N/A"."<br/>", $field->name);	
				}
			}
		}
		
		print "Director: ";
		if($result_director) {
			if($row = mysql_fetch_row($result_director))
				printf("%s %s", $row[0], $row[1]);
		}
		print "<br/>";
		
		print "Genre: ";
		if($result_genre) {
			if($row = mysql_fetch_row($result_genre))
				printf("%s", $row[0]);
			while($row = mysql_fetch_row($result_genre)) {
				printf(", %s", $row[0]);
			}
		}
		print "<br/>";
		
		print "<br/>";
		print "Actors in this Movie<br/>";
		if($result_actors) {
			while($row = mysql_fetch_row($result_actors)) {
				printf("<a href=\"./browseActor?aid=%d\">%s %s</a> as \"%s\"<br/>", 
				$row[0], $row[1], $row[2], $row[3]);
			}
		}
		
		$query_reviews = sprintf("SELECT name, time, rating, comment
								FROM Review	WHERE mid = %d",
			$_GET["mid"]);
		$query_avgscore = sprintf("SELECT AVG(rating) FROM Review
									WHERE mid = %d",
			$_GET["mid"]);
		$query_reviewcount = sprintf("SELECT count(rating) FROM Review
										WHERE mid = %d",
			$_GET["mid"]);
					
		$result_reviews = mysql_query($query_reviews, $connection);
		$result_avgscore = mysql_query($query_avgscore, $connection);
		$result_reviewcount = mysql_query($query_reviewcount, $connection);
		
		print "<br/>";
		$reviewcount = 0;
		if($result_reviewcount)
			$reviewcount = mysql_fetch_row($result_reviewcount);
		
		if($reviewcount[0] == 0) {
			print "No users have rated this movie.<br/>";
		}
		else {
			print "User Reviews<br/>";
			if($result_avgscore)
			{
				$row = mysql_fetch_row($result_avgscore);
				printf("Users have given this movie an average rating of %d/5<br/>", 
					$row[0]);
			}
			if($result_reviews) {
				while($row = mysql_fetch_row($result_reviews)) {
					printf("On %s, %s gave a rating of %d with the comment:\n%s", 
					$row[1], $row[0], $row[2], $row[3]);
				}
			}
		}
		
		printf("<a href=\"./addReview.php?mid=%d\">Comment on this movie!</a><br/>",
			$_GET["mid"]);
	}

	mysql_close($connection);
?>
</body>
</html>