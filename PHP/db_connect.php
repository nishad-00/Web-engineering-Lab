<?php
// db_connect.php

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "my_database";   

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Stop execution and display the error
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");


?>
