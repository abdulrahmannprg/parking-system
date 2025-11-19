<?php
session_start();

// التحقق من أن المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'driver') {
    header('Location: login.php');  // إذا لم يكن المستخدم قد سجل دخوله أو ليس سائقًا، إعادة التوجيه إلى صفحة تسجيل الدخول
    exit;
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم السائق</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="text-center mb-4">مرحبًا، <?= $_SESSION['username']; ?>!</h2>
    <p class="text-center">تم تسجيل الدخول بنجاح كسائق.</p>
    <a href="logout.php" class="btn btn-danger btn-block">تسجيل الخروج</a>
</div>
</body>
</html>
