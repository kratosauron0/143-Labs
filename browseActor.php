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

<b>Choose Actor:</b><br/>
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
				printf( "<option value =\"%s\">%s %s</option>",
					$row[0],
					$row[1],
					$row[2]);
			}
		}
	}
?>
</select><br/>

<?php
	mysql_close($connection);
?>
</body>
</html>