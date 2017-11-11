<?php
	$db_name="chinese_zodiac";
	$DBConnect = @mysqli_connect("localhost", "root", "", $db_name);
	$result = @mysqli_select_db($DBConnect, $DBName);
	if ($result === FALSE) 
		echo "<p>Unable to select the database. " ;
	
?>