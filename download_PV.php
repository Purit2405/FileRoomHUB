<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) { echo "❌ ไม่พบไฟล์"; exit; }
$id = intval($_POST['id']);
$stmt = $conn->prepare("SELECT * FROM files WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();
if (!$file) { echo "❌ ไม่พบไฟล์"; exit; }

$errorMsg = "";
if (isset($_POST['check'])) {
    $password = $_POST['password'];
    if (password_verify($password, $file['password'])) {
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
        } else { $errorMsg = "❌ ไฟล์ไม่พบในระบบ!"; }
    } else { $errorMsg = "❌ รหัสผ่านไม่ถูกต้อง!"; }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ใส่รหัสดาวน์โหลด</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
<div class="card shadow-sm p-4">
<h2 class="mb-4">🔒 ใส่รหัสเพื่อดาวน์โหลด: <span class="text-primary"><?= htmlspecialchars($file['job_name']) ?></span></h2>
<?php if (!empty($errorMsg)) echo "<div class='alert alert-danger'>$errorMsg</div>"; ?>
<form method="post" action="">
  <input type="hidden" name="id" value="<?= $file['id'] ?>">
  <div class="mb-3">
    <label class="form-label">รหัสผ่าน</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" name="check" class="btn btn-primary">✅ ยืนยัน</button>
  <a href="files.php" class="btn btn-secondary">← กลับไปหน้ารายการ</a>
</form>
</div>
</div>
</body>
</html>
