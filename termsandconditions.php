<?php

session_start();

include("connection.php");

include("header.php"); ?>

<div class="container" id="loginContainer">
      
	<div class="fadedBackground">
	
		<h1>Terms & Conditions</h1>
		
		<strong>These are expensive devices we're dealing with here, please read this carefully.</strong>
	
	</div>
	
	<p>1. AndroidAndy.UK is not responsible for your device or it's return to you from a loan, expect if it has been lent to AndroidAndyUK.</p>
	<p>1a. AndroidAndy.UK is not responsible for the condition of your device on it's return, expect if it has been lent to AndroidAndyUK.</p>
	

    <form method="post" id = "signUpForm">
        
        <fieldset class="col-md-6">
            	<input type="button" class="btn btn-success" value="Accept" onclick="location.href = 'index.php?status=tandc';">
        </fieldset>
		
		<fieldset class="col-md-6">
            <input type="button" class="btn btn-danger" value="Decline" onclick="location.href = 'login.php?logout=1';">
        </fieldset>
    
    </form>

</div>

<?php
    
    include("footer.php");

?>



