<html>
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

<b>Choose Movie:</b><br/>
<form method="GET">
<select name="mid">
<?php
	if($connection) {
		$query = "SELECT id, title FROM Movie
					ORDER BY title";
		
		
		$result = mysql_query($query, $connection);
		if($result) {
			while($row = mysql_fetch_row($result)) {
				if($row[1] == "")
					$row[1] = $row[0];
				printf( "<option value =\"%s\">%s</option>",
					$row[0],
					$row[1]);
			}
		}
	}
?>
</select><br/>
<input type="submit" value="Go">
</form>

<?php
	if($Sconnection){
		$query = "SELECT * FROM Movie
					ORDER BY title";
		
		
		$result = mysql_query($query, $connection);
	}

	mysql_close($connection);
?>
</body>
</html>