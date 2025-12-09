<?php
include 'db_connect.php';

// تحديد نوع المواقف المطلوبة
$type = isset($_GET['type']) ? $_GET['type'] : 'all';

// بناء الاستعلام حسب النوع
if ($type === 'vip') {
    $spots = mysqli_query($conn, "SELECT * FROM parking_spots WHERE status='available' AND is_vip = 1");
    $title = "مواقف VIP المتاحة";
} elseif ($type === 'regular') {
    $spots = mysqli_query($conn, "SELECT * FROM parking_spots WHERE status='available' AND is_vip = 0");
    $title = "المواقف العادية المتاحة";
} else {
    $spots = mysqli_query($conn, "SELECT * FROM parking_spots WHERE status='available'");
    $title = "جميع المواقف المتاحة";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?></title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">

        <span class="navbar-brand"><?= $title ?></span>

        <!-- زر الرجوع للصفحة الرئيسية -->
        <div class="ml-auto">
            <a href="index.php" class="btn btn-primary text-white">
                الرجوع للصفحة الرئيسية
            </a>
        </div>

    </div>
</nav>

<div class="container mt-4">
    <div class="text-center mb-4">
        <h2><?= $title ?></h2>
    </div>

    <div class="row">
        <?php if(mysqli_num_rows($spots) > 0): ?>

            <?php while($row = mysqli_fetch_assoc($spots)): ?>

                <!-- بطاقة موقف -->
                <div class="col-md-3 mb-4">

                    <div class="card text-center shadow 
                        <?= $row['is_vip'] == 1 ? 'border-danger' : '' ?>">

                        <div class="card-body 
                            <?= $row['is_vip'] == 1 ? 'bg-danger text-white' : '' ?>">

                            <h5 class="card-title">
                                <?= $row['spot_number']; ?>
                            </h5>

                            <p class="card-text">
                                <?= $row['is_vip'] == 1 ? 'موقف VIP' : 'موقف عادي' ?>
                            </p>

                            <!-- زر حجز -->
                            <a href="process_booking.php?spot_id=<?= $row['id']; ?>" 
                                class="btn <?= $row['is_vip'] == 1 ? 'btn-light text-danger font-weight-bold' : 'btn-primary' ?> btn-block">
                                حجز الموقف
                                </a>

                        </div>
                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>
            <div class="col-12">
                <p class="text-center">لا توجد مواقف متاحة حالياً.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
