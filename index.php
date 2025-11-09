<?php
include 'db_connect.php';

// استعلام المواقف المتاحة
$spots = mysqli_query($conn, "SELECT * FROM parking_spots WHERE status='available'");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>نظام مواقف السيارات الذكي</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- شريط التنقل -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🚗 نظام مواقف السيارات الذكي</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="booking.php">حجز موقف</a></li>
                <li class="nav-item"><a class="nav-link" href="dashboard.php">لوحة التحكم</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center mb-4">المواقف المتاحة للحجز</h2>
    <div class="row">
        <?php if(mysqli_num_rows($spots) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($spots)): ?>
                <div class="col-md-3 mb-4">
                    <div class="card text-center shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['spot_number']; ?></h5>
                            <p class="card-text">متاح</p>
                            <!-- زر الحجز يذهب لصفحة process_booking.php -->
                            <a href="process_booking.php?spot_id=<?= $row['id']; ?>" class="btn btn-success btn-block">حجز</a>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
