<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_inventaris";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function is_logged_in() {
    return isset($_SESSION['username']);
}
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>