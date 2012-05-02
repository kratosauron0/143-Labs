<html>
<head> <title>Add New Movie</title> </head>
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

<b>Add New Movie:</b>
<form method="GET">
  Title: <input type="text" name="title" maxlength="100"><br/>
  Company: <input type"text" name="company" maxlength="50"><br/>
  Year: <input type="text" name="year" maxlength="4"> <br/>
  Director: <select >
  <?php
	if($connection) {
		$query = "SELECT id, first, last FROM Director
					ORDER BY first, last";
		
		
		$result = mysql_query($query, $connection);
		if($result) {
			while($row = mysql_fetch_row($result)) {
				if($row[1] == "" && $row[2] == "")
					$row[1] = $row[0];
				printf( "<option value =\"%s\">%s %s</option>",
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
  Genre:
  <br/>
  <input type="submit" value="Add Entry"/>
</form>
<?php
	mysql_close($connection);
?>
</body>
</html>