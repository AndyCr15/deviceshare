<?php

	$emailTo = $_POST['email'];
				
	$subject = "Verify Your Email Address for Device Share";

	$message = '
	<html>
		<head>
		  <title>Activate Your Account</title>
		</head>
		<body>
			<p>Thanks for signing up!</p>
			<p>Click <a href="http://deviceshare.androidandy.uk/verifymail.php?hash='.$randomhash.'">here</a> to verify your email address</p>
			<p>Alternatively, you activation code is - '.$randomhash.'</p>
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

?>