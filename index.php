<?php

	session_start();
	
	include("connection.php");

	$status = "";
	$deldevice = "";
	
	$status = $_GET["status"];

	$deldevice = $_GET["delete"];
	
	if ($deldevice!="") {
		
		$message = "Deleting : ".$deldevice;
		
		$delquery = "DELETE FROM device WHERE id=".$deldevice;

		if (mysqli_query($link, $delquery))	{
			
			$status = "deleted";
			
		}
		
	}
	
	if($_SESSION['cookie']="read") {
		
		setcookie("cookieNotice", "read", time() + (86400 * 30), "/");
				
	}
	
	
    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }
	
	if ($status=="tandc") {
	
		$tandcquery = "UPDATE `users` SET `tandc` = 1 WHERE `id` = ".$_SESSION['id'];
		
		mysqli_query($link, $tandcquery);

	}
	
	include ("checkuser.php");
	
	include("header.php");
	
?>

<nav class="navbar navbar-light bg-faded navbar-fixed-top">
  

  <a class="navbar-brand" href="#">Device Share</a>

    <div class="pull-xs-right">
      <a href ='login.php?logout=1'>
        <button class="btn btn-success-outline" type="submit">Logout</button>
      </a>
    </div>

</nav>

<div class="container" id="homePageContainer">

	<div class="fadedBackground">

		<h1>Your Devices</h1>

	</div>


<?php
$query = "SELECT * FROM `device` WHERE user = ".$_SESSION['id'];

$result = mysqli_query($link, $query);

echo '<div class="row">';

while ($row = mysqli_fetch_array($result)) {
		
		include ("displaydevice.php");
		
	}

echo '</div>';

echo '<p><a href ="adddevice.php"><button class="btn btn-success" type="submit" style="margin:10px">Add Device</button></a></p>';

$adminquery = "SELECT * FROM `users` WHERE id = ".$_SESSION['id'];
$adminresult = mysqli_query($link, $adminquery);
$adminrow = mysqli_fetch_array($adminresult);

$level = $adminrow['level'];

if($level >= 1){
	
	echo '<div class="fadedBackground">';

		echo '<h3>Other People\'s Devices</h3>';

	echo '</div>';
	
	$query = "SELECT * FROM `device` WHERE user != ".$_SESSION['id'];

	$result = mysqli_query($link, $query);

	echo '<div class="row">';

	while ($row = mysqli_fetch_array($result)) {
			
			include ("displayothersdevice.php");
			
		}

	echo '</div>';
	
}

?>


</div>

<div id="footer">

	<?php if ($status=="verified") {
    
        echo '<div class="alert alert-info alert-dismissible" role="alert">';
		echo '<span>User Verified!</span>';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
		echo '<span aria-hidden="true">&times;</span>';
		echo '</button>';
		echo '</div>';

    }
	
	if ($status=="devicerequestsent") {
    
        echo '<div class="alert alert-info alert-dismissible" role="alert">';
		echo '<span>User Contacted! Please now await their response.</span>';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
		echo '<span aria-hidden="true">&times;</span>';
		echo '</button>';
		echo '</div>';

    } 
	
	if ($status=="deleted") {
    
        echo '<div class="alert alert-danger alert-dismissible" role="alert">';
		echo '<span>Device Deleted</span>';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
		echo '<span aria-hidden="true">&times;</span>';
		echo '</button>';
		echo '</div>';

    } 
    ?>
	
    
    <?php
        
        include("cookienotice.php");
    
    ?>
	
</div>


    
<?php
	
	include("footer.php");

?>