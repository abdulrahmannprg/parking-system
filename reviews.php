<?php
session_start();
include 'db_connect.php';

// التحقق من إذا كان المستخدم قد سجل دخوله
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن قد سجل دخوله
    exit;
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقييمات</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- ملف التنسيق الخاص بك -->
    <link rel="stylesheet" href="styles.css">

    <!-- Font Awesome للنجوم -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-dBwexv3xNq7pAo0P5PLQ4KJIp4jOSAmhpN6wX+Z1GDZCBo2yrGNsq4CPGK/c/pXHi1nKwxLBzj2Yx04Ec/2XYg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .rating i {
            color: gold;
        }
    </style>
</head>
<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">نظام مواقف السيارات الذكي</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
                    <li class="nav-item"><a class="nav-link active" href="reviews.php">التقييمات</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- محتوى صفحة التقييمات -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">تقييمات العملاء</h2>
        <div class="row">
            <?php
            // جلب آخر 5 حجوزات تم تقييمها
            $query  = "SELECT * FROM bookings WHERE rating IS NOT NULL ORDER BY booking_time DESC LIMIT 5";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $rating = (int)$row['rating'];  // قيمة التقييم من 1 إلى 5
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($row['customer_name']); ?>
                                </h5>
                                <p class="card-text mb-1">
                                    رقم السيارة: <?php echo htmlspecialchars($row['car_number']); ?><br>
                                    رقم الموقف: <?php echo htmlspecialchars($row['spot_id']); ?>
                                </p>
                                <div class="rating mb-2">
                                    <?php
                                    // عرض النجوم بناءً على التقييم
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            echo '<i class="fas fa-star"></i>';  // نجم مملوء
                                        } else {
                                            echo '<i class="far fa-star"></i>';  // نجم فارغ
                                        }
                                    }
                                    ?>
                                </div>
                                <small class="text-muted">
                                    وقت الحجز: <?php echo htmlspecialchars($row['booking_time']); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12 text-center"><p>لا توجد تقييمات حتى الآن.</p></div>';
            }
            ?>
        </div>
    </div>

    <!-- إضافة جافا سكربت من مكتبة بووتستريب -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
