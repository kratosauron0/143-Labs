<html>
<head> <title>Add New Movie</title> </head>
<body>
<?php
	# Setup database connection
	$connection = mysql_connect("localhost", "cs143", "");
	if(!$connection) {
		$errmsg = mysql_error($connection);
		print "Warning: DB Connection failure: $errmsg <br />";
	}
	else
		mysql_select_db("CS143", $connection);
?>

<h2>Add A New Movie</h2>
<form method="GET">
  Title: <input type="text" name="title" maxlength="100"><br/>
  Company: <input type="text" name="company" maxlength="50"><br/>
  Year: <input type="text" name="year" maxlength="4"> <br/>
  Director: <select name="did">
  <?php
	# Get the list of directors, each entry is associated by id
	if($connection) {
		$query = "SELECT id, first, last FROM Director
					ORDER BY first, last";
		
		# Display all the possible directors
		$result = mysql_query($query, $connection);
		if($result) {
			while($row = mysql_fetch_row($result)) {
				if($row[1] == "" && $row[2] == "")
					$row[1] = $row[0];
				printf( "<option value =\"%s\">%s %s</option>\n",
					$row[0],
					$row[1],
					$row[2]);
			}
		}
	}
  ?>
	</select><br/>
  MPAA Rating: <select name="mpaarating">
	<option value="G">G</option>
	<option value="NC-17">NC-17</option>
	<option value="PG">PG</option>
	<option value="PG-13">PG-13</option>
	<option value="R">R</option>
	<option value="Unrated">Unrated</option>
	</select><br/>
  Genre:<br/>
  <?php 
  $genres = array("Action", "Adult", "Adventure", "Animation", "Comedy", "Crime",
			"Documentary", "Drama", "Family", "Fantasy", "Horror", "Musical",
			"Mystery", "Romance", "Sci-Fi", "Short", "Thriller", "War");
	$k = 0;
	
	foreach($genres as $genre) 
	{
		if($k % 5 == 4)
		{
			printf("<input type=\"checkbox\" name=\"genre_%s\" value=\"%s\">%s   </input><br />", 
					$genre, $genre, $genre);
		}
		else
		{
			printf("<input type=\"checkbox\" name=\"genre_%s\" value=\"%s\">%s   </input>", 
					$genre, $genre, $genre);
		}
		$k++;
	}
  ?>
  <br/>
  <input type="submit" value="Add Entry"/><br/>
</form>
<?php
	# If the user has just inserted a new movie
	if($connection && $_GET["title"] && $_GET["year"] 
		&& $_GET["mpaarating"] && $_GET["company"]) {
		
		$query_id = "SELECT id FROM MaxMovieID";
		
		$result_id = mysql_query($query_id, $connection);
		$id_a = mysql_fetch_row($result_id);
		$new_id = $id_a[0] + 1;
		
		# Craft the query using user input
		# Checking? year should be number?
		$query_insert = sprintf("INSERT INTO Movie 
				Values(%d,'%s', %d, '%s', '%s')",
				$new_id,
				mysql_real_escape_string($_GET["title"]), 
				intval($_GET["year"]), 
				mysql_real_escape_string($_GET["mpaarating"]),
				mysql_real_escape_string($_GET["company"]));
				
		$query_update_id = sprintf("UPDATE MaxMovieID SET id = %d", $new_id);
		$query_director_movie = sprintf("INSERT INTO MovieDirector
								Values(%d, %d)",
				$new_id, mysql_real_escape_string($_GET["did"]));
		
		
		# Execute the query and notify user of results
		print "<hr/>\n";
		if(mysql_query($query_insert, $connection)) {
			print "Successfully added a new movie!<br/>\n";
			if(!mysql_query($query_update_id))
				print "ID update fail<br/>\n";
			if(!mysql_query($query_director_movie))
				print "Director insert failed<br/>\n";
			
			foreach($genres as $genre) {
				$genre_field = "genre_".$genre;
				if(isset($_GET[$genre_field])) {
					$query_movie_genre = sprintf("INSERT INTO MovieGenre
										Values(%d, '%s')",
						$new_id, $genre);
					if(mysql_query($query_movie_genre))
						print "Added Genre: ".$genre."<br/>";
					else
						print $query_movie_genre."<br/>";
				}
			}
		}
		else {
			print "Insert failed.".$query_insert;
		}
		
	}
	mysql_close($connection);
?>
</body>
</html>