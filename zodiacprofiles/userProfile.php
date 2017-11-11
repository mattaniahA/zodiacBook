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

	$sql = "SELECT * FROM zodiac_profiles";
	$Qresult = mysqli_query($DBConnect, $sql);

	if (mysqli_num_rows($Qresult) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($Qresult)) {
			echo "<h2>".$row["first_name"]." ".$row["last_name"]."</h2>"."<h3> (@".$row['user_name'].")</h3>" ;
			echo "Zodiac Sign: <b>" . $row['user_sign'] . "</b></br> Contact: <i>" . $row['user_email'] . "</i>";
			echo "<p>" . $row['user_profile'] . "</p>";
			echo "Uploaded Pictures:";
			//ACCESS PICTURE DATABASE
			
			$picsql = "SELECT * FROM profile_pictures where profile_id='" . $row['profile_id'] . "'";
			$picresult = mysqli_query($DBConnect, $picsql);
			if (mysqli_num_rows($picresult) > 0) {
				// output data of each row
				while($rowpic = mysqli_fetch_assoc($picresult)) {
					echo "<img src='" . $rowpic['picture_link'] . "' />";
					echo "</br>";
				}
			}
			
			echo "</br></br></br>";
		}
	} else {
		echo "0 results";
	}

	mysqli_close($DBConnect);	
	
?>
<footer>
		<?php include("profileFooter.html"); ?>  
</footer>