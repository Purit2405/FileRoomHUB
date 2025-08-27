<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) { header("Location: admin.php"); exit; }

$admin_user = "admin";
$admin_pass = "1234"; 

if (isset($_POST['login'])) {
    if ($_POST['username']==$admin_user && $_POST['password']==$admin_pass){
        $_SESSION['admin_logged_in']=true;
        header("Location: admin.php"); exit;
    } else { $error="❌ ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"; }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบแอดมิน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
<div class="card p-4 shadow-sm col-md-4 mx-auto">
<h3 class="mb-3 text-center">🔑 เข้าสู่ระบบแอดมิน</h3>
<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form method="post">
<div class="mb-3"><label>ชื่อผู้ใช้</label><input type="text" name="username" class="form-control" required></div>
<div class="mb-3"><label>รหัสผ่าน</label><input type="password" name="password" class="form-control" required></div>
<button type="submit" name="login" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
</form>
</div>
</div>
</body>
</html>
