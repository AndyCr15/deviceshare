<?php

$manquery = "SELECT * FROM `manufacturer` WHERE id = ".$row['manufacturer'];
$manresult = mysqli_query($link, $manquery);
$manrow = mysqli_fetch_array($manresult);

$romquery = "SELECT * FROM `rom` WHERE id = ".$row['rom'];
$romresult = mysqli_query($link, $romquery);
$romrow = mysqli_fetch_array($romresult);

echo '<div class="deviceContainer col-md-6 col-sm-4">';
echo '<div class="whiteBackground">';
echo $manrow['name'].' '.$row['model'].' ('.$romrow['size'].'GB) <a href="index.php?delete='.$row['id'].'"><img style="margin-left:20px" src="images/bin.png" width="15" height="20" alt="trash" /></a>';
echo '</div>';
echo '</div>';

?>