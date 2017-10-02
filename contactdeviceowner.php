<?php

	session_start();
	
	include("connection.php");


	$userquery = "SELECT * FROM `users` WHERE id = ".$_SESSION['id'];
	$userresult = mysqli_query($link, $userquery);
	$userrow = mysqli_fetch_array($userresult);

	$ownerquery = "SELECT * FROM `users` WHERE id = ".$_GET["id"];
	$ownerresult = mysqli_query($link, $ownerquery);
	$ownerrow = mysqli_fetch_array($ownerresult);
	
	$devicequery = "SELECT * FROM `device` WHERE id = ".$_GET["device"];
	$deviceresult = mysqli_query($link, $devicequery);
	$devicerow = mysqli_fetch_array($deviceresult);

	$emailTo = $ownerrow['email'];
	$emailFrom = "AndroidAndyUK <deviceshare@androidandy.uk>";
	$replyTo = $userrow['email'];
				
	$subject = "Someone Would Like To Borrow Your Device";

	$mailmessage = '
	<html>
		<head>
		  <title>Device Share - Android Andy UK</title>
		</head>
		<body>
			<p>Hi '.$ownerrow['firstname'].',</p>
			<p>Heads up! '.$userrow['firstname'].' would like to borrow your '.$devicerow['model'].'.</p>
			<p>Please contact him at '.$replyTo.' to arrange the details. (Or simply click reply to this email!)</p>
			<p>Remember, only go ahead if you\'re happy it\'s a secure deal.  AndroidAndy.UK cannot be held responsible for someone not returning your device.</p>
			<p>Thanks,</p>
			<p>Android Andy UK</p>
			<p><small>(Please do not reply to this mail, it is not monitored.)</small></p>
		</body>
	</html>
	';
	
	// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'From: '.$emailFrom;
$headers[] = 'Reply-to: '.$replyTo;

// Mail it
mail($emailTo, $subject, $mailmessage, implode("\r\n", $headers));

//echo $mailmessage;

header ("Location: index.php?status=devicerequestsent");

?>