<?php 
	session_start();
	$_SESSION = array();
	$_SESSION['userName'] = 'Root';
	//session_destroy();
	$Body = "";
	$errors = 0;
	$realpass = "";
	
	$completeForm = TRUE;
	$DisplayForm = TRUE;

	$DBName = "chinese_zodiac";
	$DBConnect = @mysqli_connect("localhost", "root", "", $DBName);
	$result = @mysqli_select_db($DBConnect, $DBName);
	if ($result === FALSE) {
		$Body .= "<font color=red>Unable to select the database.</font> " ;
		++$errors;
	}
	
//REGISTER FORM
	if(isset($_POST['register'])) {
		//SETTING USERS NAME
		if (empty($_POST['first'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to enter your first name.</font></p>\n";
		}
		else 
			$first = stripslashes($_POST['first']);
		
		if (empty($_POST['last'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to enter your last name.</font></p>\n";
		}
		else 
			$last = stripslashes($_POST['last']);
		
		//SETTING THE EMAIL
		$email = "";
		if (empty($_POST['email'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to enter an e-mail address.</font></p>\n";
		}
		else {
			$email = stripslashes($_POST['email']);
			//if (preg_match("/^[\w−]+(\.[\w−]+)*@" . "[\w−]+(\.[\w−]+)*(\.[a-zA-Z]{2, })$/i", $email) == 0) {
				////++$errors;
				//$Body .= "<p>You need to enter a valid e-mail address.</p>\n";
				//$email = "";
			//}
		}
		
		//SETTING THE USERNAME
		if (empty($_POST['username'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to enter a username.</font></p>\n";
		}
		else 
			$username = stripslashes($_POST['username']);
		
		//CHECKING AND SETTING THE PASSWORD
		if (empty($_POST['password'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to enter a password.</font></p>\n";
			$password = "";
		}
		else
			$password = stripslashes($_POST['password']);
		if (empty($_POST['password2'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to enter a confirmation
				password.</font></p>\n";
			$password2 = " ";
		}
		else
			$password2 = stripslashes($_POST['password2']);
		if ((!(empty($password))) && (!(empty($password2)))) {
			if (strlen($password) < 6) {
				++$errors;
				$Body .= "<p><font color=red>The password is too short.</font></p>\n";
				$password = "";
				$password2 = "";
			}
			if ($password <> $password2) {
				++$errors;
				$Body .= "<p><font color=red>The passwords do not match.</font></p>\n";
				$password = "";
				$password2 = "";
			}
			if($password === $password2)
				$realpass = $password;
		}
		
		//SETTING USERS SIGN
		if (empty($_POST['sign'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to enter your zodiac sign.</font></p>\n";
		}
		else 
			$sign = stripslashes($_POST['sign']);
		
		//SETTING USERS BIO
		if (empty($_POST['bio'])) {
			++$errors;
			$Body .= "<p><font color=red>You need to tell us a little about yourself for your bio.</font></p>\n";
		}
		else 
			$bio = stripslashes($_POST['bio']);
		
			
		//CHECKING REPEAT EMAIL ADDRESSES
		$TableName = "zodiac_profiles";
		if ($errors == 0) {
			$SQLstring = "SELECT count(*) FROM $TableName where user_email=$email";
			$QueryResult = @mysqli_query($DBConnect, $SQLstring);
			if ($QueryResult !== FALSE) {
				$Row = mysqli_fetch_row($QueryResult);
				if ($Row[0]>0) {
					$Body .= "<p>The email address entered (". htmlentities($email) .") is already registered.</p>\n";
					++$errors;
				}
			}
		}
		
		if ($errors > 0) {
			$completeForm = FALSE;
			//$Body .= "<p><font color=red>Please use your browser's BACK button to return to the form and fix the errors indicated.</font></p>\n";
		}
		if($completeForm == FALSE)
			$DisplayForm = TRUE;
		
		
		//PROCESSING ALL THE INFORMATION
		if ($errors == 0) {
			$DisplayForm = FALSE;
			$first = stripslashes($_POST['first']);
			$last = stripslashes($_POST['last']);
			$SQLstring = "INSERT INTO $TableName (first_name, last_name, user_email, user_name, user_password,
								user_sign, user_profile) " .
						" VALUES( '$first', '$last', '$email', '$username', '$realpass', '$sign', '$bio')";
			$QueryResult = @mysqli_query($DBConnect, $SQLstring);
			if ($QueryResult === FALSE) {
				$Body .= "<p>Unable to save your registration information. Error code " .
								mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>\n";
				++$errors;
			}
			else {
				$_SESSION['profile_id'] = mysqli_insert_id($DBConnect);
				$Body .= "Thank you for registering <b>@$username ($first $last)</b>!";
				$profileID = $_SESSION['profile_id'];
			}
			setcookie("profile_id", $profileID);
			mysqli_close($DBConnect);
		}
	}
	
	
//LOGIN FORM
	if(isset($_POST['login'])){
		$TableName = "zodiac_profiles";
		if ($errors == 0) {
			$SQLstring = "SELECT profile_id, first_name, last_name, user_name, user_sign, user_profile
							FROM $TableName" . " where user_email='" . $_POST['email'] .
						 "' and user_password='" . $_POST['password'] . "'";
			$QueryResult = @mysqli_query($DBConnect, $SQLstring);
			if (!mysqli_num_rows($QueryResult)) {
				$Body .= "<p><font color=red>The e-mail address/password combination entered is not valid. </font></p>\n";
				++$errors;
			}else {
				$Row = mysqli_fetch_assoc($QueryResult);
				$_SESSION['profile_id'] = $Row['profile_id'];
				$memberName = $Row['first_name'] . " " . $Row['last_name'];
				$username = $Row['user_name'];
				$Body .= "<p>Hey there <b>$username ($memberName)</b>!</p>\n";
			}
		}
		
		if ($errors > 0) {
			$completeForm = FALSE;
			//$Body .= "<p><font color=red>Please fix the errors indicated.</font></p>\n";
		}
		if($completeForm == FALSE)
			$DisplayForm = TRUE;
		
		if ($errors == 0) {
			$DisplayForm = FALSE;
			$Body .= "<i>We missed you!</i>";
		}
	}

?>
<html>
<head>
	<title>ZodiacBook</title>
</head>
<body>
	<header>
		<h1> <?php include("profileHeader.html"); ?></h1>
	</header>
	<?php 
		echo $Body;
		if ($DisplayForm==TRUE) { ?>
			<h2>Register / Log In</h2>
			<p>New users, please complete the top form to register as a user. 
				Returning users, please complete the second form to log in.</p>
			<hr />
			
			<h3>New Member Registration</h3>
			<form method="post" action="index.php?<?php echo SID; ?>">
				<p>Enter your name:</p> 
				<p>First: <input type="text" name="first" value="<?php if( isset($_POST['first']))echo $_POST['first'];?>" /></p>
				<p>Last: <input type="text" name="last" value="<?php if( isset($_POST['last']))echo $_POST['last'];?>" /></p>
				<p>Enter your e-mail address: <input type="text" name="email" value="<?php if( isset($_POST['email']))echo $_POST['email'];?>" /></p>
				<p>Enter your desired username: <input type="text" name="username" value="<?php if( isset($_POST['username']))echo $_POST['username'];?>" /> </p>
				<p>Enter a password for your account: <input type="password" name="password" /></p>
				<p>Confirm your password: <input type="password" name="password2" /></p>
				<p>What is your zodiac sign? <input type="text" name="sign" value="<?php if( isset($_POST['sign']))echo $_POST['sign'];?>" /> </p>
				<p>Tell us a little bit about yourself: <br /><textarea name="bio" rows="10" cols="50" > <?php if(isset($_POST['bio'])) { echo $_POST['bio']; } ?></textarea></p>
				<p><em>(Passwords are case-sensitive and must be at least 6 characters long)</em></p>
				<input type="reset" name="reset" value="Reset Registration Form" />
				<input type="submit" name="register" value="Register" />
			</form>
			<hr />
			
			<h3>Returning Member Login</h3>
			<form method="post" action="index.php?<?php echo SID; ?>">
				<p>Enter your e-mail address: <input type="text" name="email" /></p>
				<p>Enter your password: <input type="password" name="password" /></p>
				<p><em>(Passwords are case-sensitive and must be at least 6 characters long)</em></p>
				<input type="reset" name="reset" value="Reset Login Form" />
				<input type="submit" name="login" value="Log In" />
			</form>
			<hr />
	<?php } 
		if ($DisplayForm==FALSE){
			include('dashboard.php');
			//POST A PICTURE
			echo "<p><b>Upload a picture:</b></p>";
			echo "<form action='upload.php' method='post' enctype='multipart/form-data'>";
			echo "Select image to upload: <input type='file' name='fileToUpload' id='fileToUpload'>";
			echo "<input type='submit' value='Upload Image' name='submit'>";
			echo "</form></br>	</br>";
		}
	?>
	
	
	<footer>
		<?php include("profileFooter.html"); ?>  
	</footer>

</body>
</html>