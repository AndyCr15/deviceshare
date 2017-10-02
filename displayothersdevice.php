<?php

$manquery = "SELECT * FROM `manufacturer` WHERE id = ".$row['manufacturer'];
$manresult = mysqli_query($link, $manquery);
$manrow = mysqli_fetch_array($manresult);

$romquery = "SELECT * FROM `rom` WHERE id = ".$row['rom'];
$romresult = mysqli_query($link, $romquery);
$romrow = mysqli_fetch_array($romresult);

$userquery = "SELECT * FROM `users` WHERE id = ".$row['user'];
$userresult = mysqli_query($link, $userquery);
$userrow = mysqli_fetch_array($userresult);

$appquery = "SELECT * FROM `appearance` WHERE id = ".$row['appearance'];
$appresult = mysqli_query($link, $appquery);
$approw = mysqli_fetch_array($appresult);

$boxed ="Not all accessories";

if($row['boxed']) {
	
	$boxed = "Boxed";	
	
}

echo '<div class="deviceContainer col-md-6 col-sm-4">';
echo '<div class="whiteBackground">';
echo $userrow['firstname'].' '.$userrow['lastname'].' <a href="contactdeviceowner.php?id='.$userrow['id'].'&device='.$row['id'].'"><img style="margin-left:20px" src="images/email.png" width="18" height="15" alt="email" title="Ask the owner to contact you" /></a><br> <strong>'.$manrow['name'].' '.$row['model'].' ('.$romrow['size'].'GB)</strong><br>';
echo 'Condition : '.$approw['state'].'<br>Boxed : '.$boxed;
echo '</div>';
echo '</div>';

?>