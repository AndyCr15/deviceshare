<?php

    session_start();

    $error = "";  

	include("connection.php");
	
    if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: index.php");
        
    }

    if (array_key_exists("submit", $_POST)) {

		$mailquery = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
	
		$mailresult = mysqli_query($link, $mailquery);
	
		$mailrow = mysqli_fetch_array($mailresult);
	
		if (isset($mailrow)) {
			
			// send email for reset with ?hash=verifytext
			header("Location: sendpasswordreset.php?email=".$_POST['email']."&hash=".$mailrow['verifytext']);
					
		} else {
			
			$error = "That email could not be found.";
			
		}
		
	}

?>

<?php include("header.php"); ?>

<div class="container" id="loginContainer">
      
    <div class="fadedBackground">

        <h1>Device Share</h1>
        
        <strong>Reset your password.</strong>
    
    </div>
    
    <div id="error">
    
		<?php if ($error!="") {
        
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
        } ?>
    
	</div>

    <form method="post" id = "signUpForm">
        
        <p>For which email would you like to reset the password?</br>An email will be sent with a link to reset your password.</p>
        
        <fieldset class="form-group">
    
            <input class="form-control" type="email" name="email" placeholder="Your Email" required>
            
        </fieldset>
        
        <fieldset class="form-group">
            
            <input class="btn btn-success" type="submit" name="submit" value="Request Reset">
            
        </fieldset>
    
    </form>

<p class="fadedBackground"><small>[ <a href="login.php">Log In</a> ]</small></p>

</div>

<?php
    
    include("footer.php");

?>



