<?php

include("connection.php");

$query = "DELETE FROM `users` WHERE `id` = 112";

mysqli_query($link, $query);


?>