<html>
<head> <title>Add New Movie/title> </head>
<body>
Add New Movie:
<form method="GET">
  Title: <input type="text" name="title"><br/>
  Company: <input type"text" name="company"><br/>
  Year: <input type="text" name="year" maxlength="4"> <br/>
  Director: <select >
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

?>
</body>
</html>