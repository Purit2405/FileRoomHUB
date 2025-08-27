<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: admin_login.php"); exit; }
include 'db.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT * FROM files WHERE id=$id");
    $file = $res->fetch_assoc();
    if ($file && file_exists(__DIR__."/".$file['filepath'])) unlink(__DIR__."/".$file['filepath']);
    $conn->query("DELETE FROM files WHERE id=$id");
    header("Location: admin.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการไฟล์ - แอดมิน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
<h2 class="mb-4">⚙️ จัดการไฟล์ (Admin)</h2>
<a href="logout.php" class="btn btn-danger mb-3">ออกจากระบบ</a>
<a href="index.php" class="btn btn-secondary mb-3">กลับไปหน้าอัปโหลด</a>
<table class="table table-bordered bg-white shadow-sm">
<thead class="table-dark"><tr><th>ID</th><th>ชื่องาน</th><th>ไฟล์</th><th>สถานะ</th><th>จัดการ</th></tr></thead>
<tbody>
<?php
$res = $conn->query("SELECT * FROM files ORDER BY id DESC");
while($row=$res->fetch_assoc()):
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['job_name']) ?></td>
<td><?= htmlspecialchars($row['filename']) ?></td>
<td><?= $row['status'] ?></td>
<td><a href="admin.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ลบไฟล์นี้แน่ใจไหม?')">ลบ</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</body>
</html>
