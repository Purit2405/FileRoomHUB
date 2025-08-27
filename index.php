<?php
session_start();
include 'db.php';

$uploadDir = __DIR__ . "/uploads/";
if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

if (isset($_POST['upload'])) {
    $job_name = $_POST['job_name'];
    $status = $_POST['status'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $file = $_FILES['file'];
    if ($file['size'] > 10485760) { // 10MB limit
        echo "<script>alert('❌ ขนาดไฟล์ใหญ่เกิน 10MB');</script>";
        exit;
    }

    $filename = time() . "_" . basename($file['name']);
    $filepath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $filesize = filesize($filepath);
        $stmt = $conn->prepare("INSERT INTO files (job_name, filename, filepath, filesize, status, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $job_name, $filename, "uploads/".$filename, $filesize, $status, $password);
        $stmt->execute();
        echo "<script>alert('✅ อัปโหลดสำเร็จ!'); window.location='files.php';</script>";
    } else {
        echo "<script>alert('❌ อัปโหลดล้มเหลว');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>อัปโหลดไฟล์</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">📂 อัปโหลดไฟล์ + แยกเก็บไฟล์</h2>
  <form action="" method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">ตั้งชื่องาน</label>
      <input type="text" name="job_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">เลือกไฟล์</label>
      <input type="file" name="file" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">สถานะ</label>
      <div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="statusPublic" value="Public" onclick="togglePassword()" checked>
          <label class="form-check-label" for="statusPublic">Public</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status" id="statusPrivate" value="Private" onclick="togglePassword()">
          <label class="form-check-label" for="statusPrivate">Private</label>
        </div>
      </div>
    </div>
    <div class="mb-3" id="passwordBox" style="display:none;">
      <label class="form-label">ตั้งรหัสผ่าน (ถ้า Private)</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="d-flex gap-2">
      <button type="submit" name="upload" class="btn btn-primary">อัปโหลด</button>
      <a href="files.php" class="btn btn-secondary">ดูรายการไฟล์</a>
    </div>
  </form>
</div>
<script>
function togglePassword() {
  const passwordBox = document.getElementById('passwordBox');
  passwordBox.style.display = document.getElementById('statusPrivate').checked ? 'block' : 'none';
}
</script>
</body>
</html>
