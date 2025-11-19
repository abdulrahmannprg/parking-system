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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- إذا كنت تريد تخصيص إضافي في ملف styles.css -->
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">تسجيل الخروج</a></li>
                    <li class="nav-item"><a class="nav-link" href="reviews.php">التقييمات</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- محتوى صفحة التقييمات -->
    <div class="container mt-5">
        <h2 class="text-center">آراء العملاء</h2>
        <div class="row">
            <?php
            // استعلام لجلب آخر 5 تقييمات للمواقف
            $query = "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 5";
            $result = mysqli_query($conn, $query);

            // عرض التقييمات
            while ($row = mysqli_fetch_assoc($result)) {
                $rating = $row['rating'];  // الحصول على التقييم من قاعدة البيانات
                ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['username']; ?></h5>
                            <p class="card-text"><?php echo $row['review']; ?></p>
                            <div class="rating">
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
                        </div>
                    </div>
                </div>
                <?php
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
