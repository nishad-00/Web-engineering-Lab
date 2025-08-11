<?php
// =======================================================================
// == FILE: db_connect.php
// =======================================================================
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "company_db"; // Or "matrimony_db" if you created a new one

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Start session on all pages that need it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>