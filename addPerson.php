<html>
<head> <title>Add New Person</title> </head>
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

<h2>Add A New Actor/Director</h2>
<form method="GET">
  Identity: <input type="radio" name="identity" value="Actor" checked="true">Actor
			<input type="radio" name="identity" value="Director">Director<br/>
  First Name: <input type="text" name="first" maxlength="20"><br/>
  Last Name: <input type="text" name="last" maxlength="20"><br/>
  Sex: <input type="radio" name="sex" value="Male" checked="true">Male
		<input type="radio" name="sex" value="Female">Female<br/>
  <i>NOTE: Format dates as YYYYMMDD</i><br />
  Date of Birth: <input type="text" name="dob"> <br/>
  Date of Death: <input type="text" name="dod"> (<i>Leave blank if not dead</i>)<br/>
  <input type="submit" value="Add!"/><br/>
</form>
<?php
	# If the user has just inserted a new person
	if($connection && $_GET["identity"] && $_GET["sex"]) {
		if(!$_GET["dob"])
			$_GET["dob"] = 'NULL';
		if(!$_GET["dod"])
			$_GET["dod"] = 'NULL';
		$query_id = "SELECT id FROM MaxPersonID";
		
		$result_id = mysql_query($query_id, $connection);
		$id_a = mysql_fetch_row($result_id);
		$new_id = $id_a[0] + 1;
		
		# Craft the query using user input
		if($_GET["identity"] == "Actor")
			$query_insert = sprintf("INSERT INTO Actor 
					Values(%d,'%s', '%s', '%s', %s, %s)",
					$new_id,
					mysql_real_escape_string($_GET["last"]), 
					mysql_real_escape_string($_GET["first"]),
					mysql_real_escape_string($_GET["sex"]), 
					$_GET["dob"],
					$_GET["dod"]);
		else if($_GET["identity"] == "Director")
			$query_insert = sprintf("INSERT INTO Director 
					Values(%d,'%s', '%s', %s, %s)",
					$new_id,
					mysql_real_escape_string($_GET["last"]), 
					mysql_real_escape_string($_GET["first"]),
					$_GET["dob"],
					$_GET["dod"]);
				
		$query_update_id = sprintf("UPDATE MaxPersonID SET id = %d", $new_id);
		
		
		# Execute the query and notify user of results
		print "<hr/>\n";
		if(mysql_query($query_insert, $connection)) 
		{
			if($_GET["identity"] == "Actor")
				print "Successfully added new actor!<br/>\n";
			else
				print "Successfully added new director!<br/>\n";
			
			if(!mysql_query($query_update_id))
				print "ID update fail<br/>\n";
		}
		else {
			print "Insert failed.".$query_insert;
		}
		
	}
	mysql_close($connection);
?>
</body>
</html>