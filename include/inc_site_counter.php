<?php
$db_name="chinese_zodiac";
$DBConnect = @mysqli_connect("localhost", "root", "", $db_name);
$result = @mysqli_select_db($DBName, $DBConnect);
if ($result === FALSE) 
	echo "<p>Unable to select the database. " ;

if (empty($_COOKIE["visits"])) {
	// increment the counter in the database
	mysqli_query($DBConnect, "UPDATE visit_counter " .
	" SET counter = counter + 1 " .
	" WHERE id = 1 ");
	// query the visit_counter table and assign the counter value to the $visitors variable
	$queryResult = mysqli_query($DBConnect, "SELECT counter " .
	" FROM visit_counter WHERE id = 1" );
	if (($row = mysqli_fetch_assoc($queryResult)) !== FALSE)
		$visitors = $row['counter'];
	else
		$visitors = 1;
	// Set the cookie value
	setcookie("visits", $visitors, time()+(60*60*24));
}
else // Otherwise, assign the cookie value to the $visitor variable
	$visitors = $_COOKIE["visits"];
?>