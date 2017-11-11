<?php 
	session_start();
	if(isset($_SESSION['userName'])) {
	  echo "Your session is running " . $_SESSION['userName'];
	}
	if(isset($_POST['submit'])){
		$DBName = "chinese_zodiac";
		$tableName = "profile_pictures";
		$DBConnect = @mysqli_connect("localhost", "root", "", $DBName);
		$result = @mysqli_select_db($DBConnect, $DBName);
		if ($result === FALSE) {
			$Body .= "<font color=red>Unable to select the database.</font>" . mysqli_connect_error() ;
			++$errors;
		}
	
		$target_dir = "useruploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				//echo "File is an image - " . $check["mime"] . ".";
				echo "</br>";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		
		//ADDING PIC INFO TO DATABASE
		$sql = "INSERT INTO `profile_pictures` (`profile_id`, `picture_link`) 
					VALUES ('" . $_SESSION['profile_id'] . "', '" . $target_file ."')";
		$Qresult = mysqli_query($DBConnect, $sql);
		
	}
?>

