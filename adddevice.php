<?php

session_start();

include("connection.php");

$message = "";

$message = $_GET["status"];

if (array_key_exists("id", $_COOKIE) && $_COOKIE['id']) {
	
	$_SESSION['id'] = $_COOKIE['id'];
	
}

include("checkuser.php");

include("header.php");

if(array_key_exists("submit", $_POST)) {
	
	if (!$_POST['manufacturer'] OR !$_POST['model'] OR !$_POST['rom'] OR !$_POST['ram'] OR !$_POST['condition']){
		
		$error .= "Please complete all details.<br>";
		
	} else {
		
		$query = "INSERT INTO `device` (`user`, `manufacturer`, `model`, `rom`, `ram`, `appearance`, `boxed`) VALUES ('".$_SESSION['id']."', '".$_POST['manufacturer']."', '".mysqli_real_escape_string($link, $_POST['model'])."', '".$_POST['rom']."', '".$_POST['ram']."', '".$_POST['condition']."', '".$_POST['boxed']."')";

		if (!mysqli_query($link, $query)) {
	
			$error = "<p>Could not add device.</p>";
			$error = mysqli_error($link);
	
		} else {
			
			// email me that a device has been added?
			$error = "Added";
			header("Location: index.php");
			
		}
		
	}
	
}



?>

<nav class="navbar navbar-light bg-faded navbar-fixed-top"> <a class="navbar-brand" href="#">Device Share</a>
  <div class="pull-xs-right"> <a href ='login.php?logout=1'>
    <button class="btn btn-success-outline" type="submit">Logout</button>
    </a> </div>
</nav>
<div class="container" id="homePageContainer">

	<div class="fadedBackground">

		<h1>Add A Device</h1>
		
        <strong>Please enter the details of the device you are prepared to share.</strong>

	</div>
	
    <div id="error">
    
	<?php if ($error!="") {
        
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
        } 
        ?>
  </div>
  
  <form method="post" id = "addDevice">
    <fieldset class="col-md-6">
      <select class="form-control" name="manufacturer" placeholder="Manufacturer">
        <option value="" disabled selected>Manufacturer</option>
        <?php
                $query = "SELECT * FROM `manufacturer`";
                $result = mysqli_query($link, $query);
                while ($row = mysqli_fetch_array($result)) {
					?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php
                }
                ?>
      </select>
    </fieldset>
    <fieldset class="col-md-6">
      <input class="form-control" type="text" name="model" placeholder="Model">
    </fieldset>
    <fieldset class="col-md-6">
      <select class="form-control" name="rom" placeholder="Rom">
        <option value="" disabled selected>Storage Size (GB)</option>
        <?php
                    $query = "SELECT * FROM `rom`";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['size']; ?></option>
        <?php
                    }
                    ?>
      </select>
    </fieldset>
    <fieldset class="col-md-6">
      <select class="form-control" name="ram" placeholder="Ram">
        <option value="" disabled selected>RAM (GB)</option>
        <?php
                    $query = "SELECT * FROM `ram`";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['size']; ?></option>
        <?php
                    }
                    ?>
      </select>
    </fieldset>
    <fieldset class="col-md-6">
      <select class="form-control" name="condition" placeholder="Condition">
        <option value="" disabled selected>Condition</option>
        <?php
                    $query = "SELECT * FROM `appearance`";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['state']; ?></option>
        <?php
                    }
                    ?>
      </select>
    </fieldset>
    <fieldset class="col-md-6">
      <select class="form-control" name="boxed" placeholder="Boxed">
        <option value=1>Boxed with Accessories</option>
        <option value=0>Not complete</option>
      </select>
    </fieldset>
    <fieldset class="col-md-4">
      <a href ="index.php">
      <input class="btn btn-danger" type="button" name="cancel" value="Cancel">
      </a>
    </fieldset>
    <fieldset class="col-md-4">
      <input class="btn btn-warning" type="reset" name="reset" value="Reset">
    </fieldset>
    <fieldset class="col-md-4">
      <input class="btn btn-success" type="submit" name="submit" value="Add Device">
    </fieldset>
  </form>
</div>

<?php
	
	include("footer.php");

?>