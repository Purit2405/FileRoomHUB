<?php
$host = "localhost";
$user = "if0_39798214";    
$pass = "ZpdXdBJU64L5y2G"; 
$dbname = "if0_39798214_file_room";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
