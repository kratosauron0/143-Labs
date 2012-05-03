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

<b>Add New Movie:</b>
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
	foreach($genres as $genre) {
	printf("<input type=\"checkbox\" name=\"genre_%s\" value=\"%s\">%s</input>", 
		$genre, $genre, $genre);
	}
  ?>
  <br/>
  <input type="submit" value="Add Entry"/><br/>
</form>
<?php
	# If the user has just inserted a new movie
	if($connection && $_GET["title"] && $_GET["year"] 
		&& $_GET["mpaarating"] && $_GET["company"]) {
		# Craft the query using user input
		# Checking? year should be number?
		$query = sprintf("INSERT INTO Movie 
				Values(,'%s', %d, '%s', '%s')",
				mysql_real_escape_string($_GET["title"]), 
				intval($_GET["year"]), 
				mysql_real_escape_string($_GET["mpaarating"]),
				mysql_real_escape_string($_GET["company"]));
				
		# For testing, simply print the query to see
		print $query."</br>";
		
		# Execute the query and notify user of results
	}
	mysql_close($connection);
?>
</body>
</html>