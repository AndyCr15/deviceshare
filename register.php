<?php

	session_start();

    $error = "";
	
	if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: index.php");
        
    }
	
	if(array_key_exists("submit", $_POST)) {
		
		include("connection.php");
		
		if (!$_POST['email']){
			
			$error .= "An email address is required<br>";
			
		}
		
		if (!$_POST['password']){
			
			$error .= "A password is required<br>";
			
		} else {
			
			$thisPass = mysqli_real_escape_string($_POST['password']);
			
		}
		
		if (!$_POST['firstname']){
			
			$error .= "Please provide your first name.<br>";
			
		}
		
		if (!$_POST['lastname']){
			
			$error .= "Please provide your last name.<br>";
			
		}
		
		if (!$_POST['phonenumber'] OR !ctype_digit($_POST['phonenumber']) OR (strlen ($_POST['phonenumber']) < 11 )){
			
			$error .= "Please provide a valid contact phone number.<br>";
			
		}
		
		if (!$_POST['postcode'] OR (strlen ($_POST['postcode']) < 5 )){
			
			$error .= "Please provide your full postcode.<br>";
			
		}
		
		if ($error){
		
			$error = "<p><strong>There were errors in your form:</strong></p>".$error;	
			
		} else {
			
			$query = "SELECT id FROM `users` WHERE email = '".strtolower(mysqli_real_escape_string($link, $_POST['email']))."' LIMIT 1";
			
			$result = mysqli_query($link, $query);
			
			$row = mysqli_fetch_array($result);
			
			if (isset($row)) {
			
				$error = "That email is already registered.";
					
			} else {
				
				$randomhash = md5(strtolower(mysqli_real_escape_string($link, $_POST['email'])).'salty');
				
				$query = "INSERT INTO `users` (`email`, `password`, `firstname`, `lastname`, `phonenumber`, `postcode`, `verifytext`) VALUES ('".strtolower(mysqli_real_escape_string($link, $_POST['email']))."', '".$thisPass."', '".mysqli_real_escape_string($link, $_POST['firstname'])."', '".mysqli_real_escape_string($link, $_POST['lastname'])."', '".mysqli_real_escape_string($link, $_POST['phonenumber'])."', '".mysqli_real_escape_string($link, $_POST['postcode'])."', '".$randomhash."')";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";
						$error = mysqli_error($link);

                    } else {
						
						/*$salt = password_hash(mysqli_insert_id($link), PASSWORD_DEFAULT);
						$hash = password_hash($salt.$thisPass, PASSWORD_DEFAULT);

                        $query = "UPDATE `users` SET password = '".$hash."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";*/
                        
						$query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
						
                        $id = mysqli_insert_id($link);
                        
                        mysqli_query($link, $query);

                        $_SESSION['id'] = $id;

                        if ($_POST['stayLoggedIn'] == '1') {

                            setcookie("id", $id, time() + 60*60*24*365);

                        }
						
						include("sendemailverification.php");

                        header("Location: index.php");
					
				}
				
			}
			
		}
		
	}

	include("header.php");

?>


<?php include("header.php"); ?>
      
<div class="container" id="loginContainer">

	<?php include("logintitle.php"); ?>
    
    <form method="post" id = "signUpForm">
            
        <fieldset class="col-md-6">
    
            <input class="form-control" type="email" name="email" placeholder="Your Email">
            
        </fieldset>
        
        <fieldset class="col-md-6">
        
            <input class="form-control" type="password" name="password" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" title="Must be 8 chars, upper and lower case with a number">
            
        </fieldset>
        
        <fieldset class="col-md-6">
        
            <input class="form-control" type="firstname" name="firstname" placeholder="First Name">
            
        </fieldset>
        
        <fieldset class="col-md-6">
        
            <input class="form-control" type="lastname" name="lastname" placeholder="Last Name">
            
        </fieldset>
        
        <fieldset class="col-md-6">
        
            <input class="form-control" type="phonenumber" name="phonenumber" placeholder="Contact Phone Number">
            
        </fieldset>
        
        <fieldset class="col-md-6">
        
            <input class="form-control" type="postcode" name="postcode" placeholder="Post Code" pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}">
            
        </fieldset>
        
        <div class="col-md-12">
        
            <label>
        
            	<input type="checkbox" name="stayLoggedIn" value=0> Stay logged in
                
            </label>
            
        </div>
        
        <fieldset class="form-group">

            <input class="btn btn-success" type="submit" name="submit" value="Register">
            
        </fieldset>

    </form>

	<p class="fadedBackground"><small>[ <a href="login.php">Log In</a> ]</small></p>

</div>

<?php

	include("footer.php");
    
?>


