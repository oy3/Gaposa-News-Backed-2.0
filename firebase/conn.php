<?php
$servername = "localhost";
$username = "gaposane_gpnews";
$password = "temitope123";
$dbname = "gaposane_gaposadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 // Check connection
 if ($conn) {
    //  echo"connected";
}
else{
     echo "DB not connected";
	exit();
} ?>
