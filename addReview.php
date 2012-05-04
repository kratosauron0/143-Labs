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

<h2>Submit a Review</h2>

<i>You are required to submit a name with your review</i><br /><br />

<form method="GET">
<b>Movie: </b>
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
<b>Name: </b>
<input type="text" name = "name" maxlength="20"></br>

<b>Rating: </b>
<select name="rating">
	<option value="1"> 1 - *@#!?</option>
	<option value="2"> 2 - Poor</option>
	<option value="3"> 3 - Mediocre</option>
	<option value="4"> 4 - Good!</option>
	<option value="5"> 5 - Amazing!</option>
</select><br />

<b>Review: </b><br/>
<textarea name="comment" cols="80" rows="10">
</textarea><br/>

<input type="submit" value="Submit Review">
</form>

<?php
	$date = getdate();
	
	# Generate review information from input fields
	$name = mysql_real_escape_string($_GET[name], $connection);	
	
	$time = $date[year] * 10000000000 + $date[mon] * 100000000 + $date[mday] * 1000000;
	$time += $date[hours] * 10000 + $date[minutes]*100 + $date[seconds];
	$mid = $_GET[mid];
	$rating = $_GET[rating];
	$comment = 	mysql_real_escape_string($_GET[comment], $connection);
	
	# Insert Review into Table
	if( $name != "")
	{
		$format = "INSERT INTO Review VALUES ('%s', %f, %d, %d, '%s')";
		$query = sprintf($format, $name, $time, $mid, $rating, $comment);
		
		if($result = mysql_query($query, $connection))
		{
			echo "<i>Successfully submitted review!<br />";
		}
		else
		{
			echo "<i>There was a problem in submitting your review.<br />";
		}
	}
	
	mysql_close($connection);
?>

</body>
</html>