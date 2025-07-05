<?php
$host = 'sql305.infinityfree.com';
$db   = 'if0_39399868_startup_platform';
$user = 'if0_39399868';  // or your db user
$pass = 'web3hack';      // your db password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
