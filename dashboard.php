<?php
session_start();

// التحقق من أن المستخدم قد سجل الدخول وأنه مشرف
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');  // إذا لم يكن مشرفًا أو لم يسجل دخوله، إعادة التوجيه إلى صفحة تسجيل الدخول
    exit;
}

// الاتصال بقاعدة البيانات
include 'db_connect.php';

// استعلام المواقف المتاحة
$spots = mysqli_query($conn, "SELECT * FROM parking_spots");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المشرف</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="text-center mb-4">مرحبًا، <?= $_SESSION['username']; ?>!</h2>
    <p class="text-center">تم تسجيل الدخول بنجاح كمشرف.</p>

    <!-- عرض المواقف -->
    <h4 class="text-center mb-4">إدارة المواقف</h4>
    <div class="row">
        <?php if(mysqli_num_rows($spots) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($spots)): ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-center shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['spot_number']; ?></h5>
                            <p class="card-text"><?= $row['status']; ?></p>
                            <!-- يمكنك إضافة المزيد من العمليات هنا للمشرف مثل تحديث أو حذف الموقف -->
                            <a href="delete_parking_spot.php?spot_id=<?= $row['id']; ?>" class="btn btn-danger btn-block">حذف</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">لا توجد مواقف حالياً.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- زر تسجيل الخروج -->
    <a href="logout.php" class="btn btn-danger btn-block mt-4">تسجيل الخروج</a>
</div>
</body>
</html>
