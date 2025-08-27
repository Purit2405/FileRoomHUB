<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>รายการไฟล์</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">📑 รายการไฟล์</h2>
  <a href="index.php" class="btn btn-secondary mb-3">← กลับไปอัปโหลด</a>
  <table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>ชื่องาน</th>
        <th>ขนาด (KB)</th>
        <th>สถานะ</th>
        <th>ดาวน์โหลด</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM files ORDER BY id DESC");
      while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['job_name']) ?></td>
        <td><?= round($row['filesize']/1024,1) ?></td>
        <td><?= $row['status'] ?></td>
        <td>
          <?php if($row['status']=="Public"): ?>
            <a href="download.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">ดาวน์โหลด</a>
          <?php else: ?>
            <form action="download_PV.php" method="post" class="d-inline">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button type="submit" class="btn btn-warning btn-sm">ใส่รหัสเพื่อโหลด</button>
            </form>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
