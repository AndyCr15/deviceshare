<?php

$checkquery = "SELECT * FROM `users` WHERE id = '".$_SESSION['id']."'";
			
$checkresult = mysqli_query($link, $checkquery);

$checkrow = mysqli_fetch_array($checkresult);

if (isset($checkrow)) {
	
	$userName = $checkrow['firstname']." ".$checkrow['lastname'];
	
}

if (array_key_exists("id", $_SESSION)) {
		  
	// check user is verified
	
	if ($checkrow['verified'] == 0) {
		
		header("Location: verifymail.php");
		
	}
	
	if($checkrow['tandc'] == 0) {
		
		header("Location: termsandconditions.php");
		
	}
  
} else {
	
	header("Location: login.php");
	
}
    
?>