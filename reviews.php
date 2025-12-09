<?php
session_start();
include 'db_connect.php';

// التحقق من إذا كان المستخدم قد سجل دخوله
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// جلب جميع الحجوزات التي تحتوي على تقييم
$query = "SELECT bookings.*, parking_spots.spot_number 
          FROM bookings 
          LEFT JOIN parking_spots 
          ON bookings.spot_id = parking_spots.id
          WHERE bookings.rating IS NOT NULL 
          ORDER BY bookings.booking_time DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقييمات العملاء</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    <style>
        .rating i {
            color: gold;
            font-size: 18px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">نظام مواقف السيارات الذكي</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link active" href="reviews.php">التقييمات</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <h3 class="text-center mb-4">تقييمات العملاء</h3>

    <div class="row">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">

                            <h5 class="card-title"><?= $row['customer_name']; ?></h5>

                            <!-- النجوم -->
                            <div class="rating mb-2">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $row['rating']
                                        ? '<i class="fas fa-star"></i>'
                                        : '<i class="far fa-star"></i>';
                                }
                                ?>
                            </div>

                            <p class="card-text">رقم السيارة: <?= $row['car_number']; ?></p>
                            <p class="card-text">رقم الموقف: <?= $row['spot_number']; ?></p>
                            <p class="card-text text-muted">وقت الحجز: <?= $row['booking_time']; ?></p>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        <?php else: ?>
            <div class="col-12 text-center">
                <p>لا توجد تقييمات حتى الآن.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
