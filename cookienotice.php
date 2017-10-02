<?php 

$read = "Testing";

if (array_key_exists("cookieNotice", $_COOKIE) && $_COOKIE ['cookieNotice']) {
        
        $read = $_COOKIE['cookieNotice'];
        
    }

if ($read!="read") {
	$cookiemessage = "This website uses cookies to maintain your session. Nothing more.  By not logging out, you are agreing to them being used in this way.";
	echo '<div class="alert alert-warning alert-dismissible" role="alert" id="cookieAlert">';
	echo '<span>'.$cookiemessage.'</span>';
	echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
	echo '<span aria-hidden="true">&times;</span>';
	echo '</button>';
	echo '</div>';
	
} 
?>