<?php
$host = 'localhost';
$db   = 'startup_platform';
$user = 'root';  // or your db user
$pass = '';      // your db password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
