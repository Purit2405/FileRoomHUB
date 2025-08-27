<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) { echo "❌ ไม่พบไฟล์"; exit; }
$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM files WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();
if (!$file) { echo "❌ ไม่พบไฟล์"; exit; }

$filePath = __DIR__ . "/" . $file['filepath'];
$fileName = $file['filename'];
if (file_exists($filePath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Content-Length: ' . filesize($filePath));
    flush();
    readfile($filePath);
    exit;
} else { echo "❌ ไฟล์ไม่พบในระบบ"; exit; }
?>
