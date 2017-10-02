<?php

    session_start();

    $error = "";  

	include("connection.php");
	
    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
        session_destroy();
		
		header("Location: login.php");
        
    } else if (array_key_exists("delete", $_GET)) {
        
		$query = "DELETE FROM users WHERE id = '".$_SESSION['id']."'";
		
		
		if($result = mysqli_query($link, $query)) {
			
			$error = "User Deleted!";
			
		}
		
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
        session_destroy();
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: index.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p><strong>There were errors in your form:</strong></p>".$error;
            
        } else {
                                
                    $mailquery = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                    $mailresult = mysqli_query($link, $mailquery);
                
                    $mailrow = mysqli_fetch_array($mailresult);
                
                    if (isset($mailrow)) {
                        
						/*$salt = password_hash($row['id'], PASSWORD_DEFAULT);
						$hashedPassword = password_hash($salt.$_POST['password'], PASSWORD_DEFAULT);
                        
                        if (password_verify($row['password'], $hashedPassword)) {*/
                            
						$hashedPassword = md5(md5($mailrow['id']).$_POST['password']);
                        
                        if ($hashedPassword == $mailrow['password']) {
							
                            $_SESSION['id'] = $mailrow['id'];
                            
                            if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $mailrow['id'], time() + 60*60*24*365);

                            } 

                            header("Location: index.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }

?>

<?php include("header.php"); ?>

<div class="container" id="loginContainer">
      
    <?php include("logintitle.php"); ?>

    <form method="post" id = "signUpForm">
        
        <p>Log in using your username and password.</p>
        
        <fieldset class="form-group">
    
            <input class="form-control" type="email" name="email" placeholder="Your Email">
            
        </fieldset>
        
        <fieldset class="form-group">
        
            <input class="form-control"type="password" name="password" placeholder="Password">
            
        </fieldset>
        
        <div class="checkbox">
        
            <label>
        
                <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in
                
            </label>
            
        </div>
        
        <fieldset class="form-group">
            
            <input class="btn btn-success" type="submit" name="submit" value="Log In!">
            
        </fieldset>
    
    </form>

<p class="fadedBackground"><small>[ <a href="register.php">Register</a> ]     [ <a href="resetrequest.php">Forgotten Password</a> ]</small></p>

</div>

<?php
    
    include("footer.php");

?>



