<?php

	$emailTo = $_GET['email'];
	$hash = $_GET['hash'];
				
	$subject = "Password Reset Request at Device Share";

	$message = '
	<html>
		<head>
		  <title>Reset Your Password</title>
		</head>
		<body>
			<p>Click <a href="http://deviceshare.androidandy.uk/passwordreset.php?hash='.$hash.'">here</a> to set a new password.</p>
		</body>
	</html>
	';
	
	// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'From: AndroidAndyUK <mail@androidandy.uk>';

// Mail it
mail($emailTo, $subject, $message, implode("\r\n", $headers));

header("Location: login.php");

?>