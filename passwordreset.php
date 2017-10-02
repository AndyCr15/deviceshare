<?php

	session_start();
	
	include("connection.php");

    $error = "";
	
	$thishash = $_GET["hash"];
	
	if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: index.php");
        
    }
	
	if(array_key_exists("submit", $_POST)) {
		
		$thisPass = mysqli_real_escape_string($_POST['password']);
	
		$query = "SELECT * FROM `users` WHERE verifytext = '".strtolower(mysqli_real_escape_string($link, $thishash))."' LIMIT 1";
		
		$result = mysqli_query($link, $query);
		
		$row = mysqli_fetch_array($result);
		
		$id = $row['id'];
		
		$query = "UPDATE `users` SET password = '".md5(md5($id).$_POST['password'])."' WHERE id = ".$id." LIMIT 1";
		
		mysqli_query($link, $query);

		$_SESSION['id'] = $id;

		if ($_POST['stayLoggedIn'] == '1') {

			setcookie("id", $id, time() + 60*60*24*365);

		}

		header("Location: index.php");
		
	}

	include("header.php");

?>


<?php include("header.php"); ?>
      
<div class="container" id="loginContainer">

	<div class="fadedBackground">

        <h1>Device Share</h1>
        
        <strong>Change Your Password</strong>
    
    </div>
    
    <p>Enter your new password.</p>
    
    <div id="error">
        
	<?php if ($error!="") {
    
        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';

    } 
    ?>
    
</div>
    
    <form method="post" id = "signUpForm">
        
        <fieldset>
        
            <input class="form-control" type="password" name="password" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" title="Must be 8 chars, upper and lower case with a number" required>
            
        </fieldset>
        
        <div class="col-md-12">
        
            <label>
        
            	<input type="checkbox" name="stayLoggedIn" value=0> Stay logged in
                
            </label>
            
        </div>
        
        <fieldset class="form-group">

            <input class="btn btn-success" type="submit" name="submit" value="Set Password">
            
        </fieldset>

    </form>

	<p class="fadedBackground"><small>[ <a href="login.php">Log In</a> ]</small></p>

</div>

<?php

	include("footer.php");
    
?>


