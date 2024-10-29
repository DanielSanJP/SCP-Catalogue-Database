<?php
include 'credentials.php'; // Ensure this path is correct

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for a connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
