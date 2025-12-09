<?php
session_start();

// السماح للمشرف فقط
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $spot_number = $_POST['spot_number'];
    $is_vip      = isset($_POST['is_vip']) ? 1 : 0;

    // عند الإضافة نخلي الحالة متاحة
    $status = 'available';

    $sql = "INSERT INTO parking_spots (spot_number, status, is_vip)
            VALUES ('$spot_number', '$status', '$is_vip')";

    if (mysqli_query($conn, $sql)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "حدث خطأ أثناء إضافة الموقف: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة موقف جديد</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="text-center mb-4">إضافة موقف جديد</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>رقم الموقف (مثال: A1, B2 ...):</label>
            <input type="text" name="spot_number" class="form-control" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="is_vip" class="form-check-input" id="vipCheck">
            <label class="form-check-label" for="vipCheck">موقف VIP</label>
        </div>
        <button type="submit" class="btn btn-primary btn-block">حفظ التعديلات</button>


        <a href="dashboard.php" class="btn btn-secondary btn-block mt-2">الرجوع للوحة التحكم</a>
    </form>
</div>
</body>
</html>
