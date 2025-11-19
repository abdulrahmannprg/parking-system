<?php
session_start();
include 'db_connect.php';  // الاتصال بقاعدة البيانات

$error = '';  // لتخزين رسائل الخطأ

// التحقق من حالة الجلسة (إذا كان المستخدم قد سجل الدخول بالفعل)
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: dashboard.php');  // إعادة توجيه المشرف إلى لوحة التحكم
    } else {
        header('Location: index.php');  // إعادة توجيه السائق إلى الصفحة الرئيسية
    }
    exit;
}

// التحقق من بيانات النموذج بعد إرسالها
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';  // استلام اسم المستخدم
    $password = $_POST['password'] ?? '';  // استلام كلمة المرور

    // استعلام للتحقق من وجود المستخدم في قاعدة البيانات
    $stmt = mysqli_prepare($conn, "SELECT id, password, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash, $role);  // استرجاع id وكلمة المرور المشفرة وrole
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_fetch($stmt);  // جلب البيانات من الاستعلام

        // التحقق من كلمة المرور المدخلة باستخدام password_verify()
        if (password_verify($password, $hash)) {
            // إذا كانت كلمة المرور صحيحة، يتم تخزين بيانات الجلسة
            session_regenerate_id(true);
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;  // تخزين الدور (admin أو driver)

            // إعادة التوجيه بناءً على الدور
            if ($role === 'admin') {
                header('Location: dashboard.php');  // توجيه المشرف إلى لوحة التحكم
            } elseif ($role === 'driver') {
                header('Location: index.php');  // توجيه السائق إلى الصفحة الرئيسية
            }
            exit;
        } else {
            $error = "اسم المستخدم أو كلمة المرور غير صحيحة.";  // كلمة المرور غير صحيحة
        }
    } else {
        $error = "اسم المستخدم أو كلمة المرور غير صحيحة.";  // اسم المستخدم غير موجود
    }

    mysqli_stmt_close($stmt);  // إغلاق الاستعلام
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>تسجيل دخول</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container" style="max-width:480px; margin-top:80px;">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-center">تسجيل دخول</h4>
            <?php if($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label>اسم المستخدم</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary btn-block">دخول</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
