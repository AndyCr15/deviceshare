<?php

    session_start();

    $error = "";  

	include("connection.php");
	
	$code = "";
	$code = $_GET["hash"];
	
    if (!empty($code)) {
		
		$query = "SELECT * FROM `users` WHERE verifytext = '".$code."' LIMIT 1";
                
		$result = mysqli_query($link, $query);
	
		$row = mysqli_fetch_array($result);
	
		if (isset($row)) {


			$query = "UPDATE `users` SET verified = 1 WHERE `id` = ".$row['id']." LIMIT 1";
									
			mysqli_query($link, $query);

			$error = "User Verified!";
			
			header("Location: index.php?status=verified");

	}
	   
	   
	   
    }

    if (array_key_exists("submit", $_POST)) {
        
        if (!$_POST['hash']) {
            
            $error .= "Please enter your code<br>";
            
        } 
        
	}

?>

<?php include("header.php"); ?>

<div class="container" id="homePageContainer">


    <form id = "signUpForm">
        
        <p class="fadedBackground">You will receive an email shortly.</br>Click the link in it to verify your account.</p>
        
        <fieldset class="form-group">
    
            <input class="form-control" type="hash" name="hash" placeholder="Your Code">
            
        </fieldset>
        
        <fieldset class="form-group">
            
            <input class="btn btn-success" type="submit" name="submit" value="Verify">
            
        </fieldset>
    
    </form>

</div>

<?php
    
    include("footer.php");

?>



