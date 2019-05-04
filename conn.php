<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "gaposa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn) {
} else {
    echo "DB not connected";
    exit();
}
?>