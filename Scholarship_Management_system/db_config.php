<?php
$host = "localhost";
$user = "root";
$pass = "12345";
$dbname = "sms";  // ← DB name in XAMPP

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
