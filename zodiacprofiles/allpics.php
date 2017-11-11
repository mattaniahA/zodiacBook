<header>
		<h1> <?php include("profileHeader.html"); ?></h1>
</header>

<?php 
	$DBName = "chinese_zodiac";
	$DBConnect = @mysqli_connect("localhost", "root", "", $DBName);
	$result = @mysqli_select_db($DBConnect, $DBName);
	if ($result === FALSE) {
		$Body .= "<font color=red>Unable to select the database.</font>" . mysqli_connect_error() ;
		++$errors;
	}

	$sql = "SELECT * FROM profile_pictures";
	$Qresult = mysqli_query($DBConnect, $sql);

	if (mysqli_num_rows($Qresult) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($Qresult)) {
			echo "<img src='" . $row['picture_link'] . "' />";
			echo "</br>";
		}
	} else {
		echo "0 results";
	}

	mysqli_close($DBConnect);	
	
?>

<footer>
		<?php include("profileFooter.html"); ?>  
</footer>